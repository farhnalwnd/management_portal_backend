<?php

namespace App\Observers;

use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;

class ActivityObserver
{
    /**
     * Handle the Activity "creating" event.
     */
    public function creating(Activity $activity): void
    {
        // Use attribute_changes as it's the primary JSON field in this project
        // Explicitly convert to array to avoid "Indirect modification has no effect"
        $changes = $activity->attribute_changes;
        if ($changes instanceof \Illuminate\Support\Collection) {
            $changes = $changes->toArray();
        }

        if (empty($changes)) {
            $properties = $activity->properties;
            if ($properties instanceof \Illuminate\Support\Collection) {
                $changes = $properties->toArray();
            } else {
                $changes = (array) $properties;
            }
        }

        if (empty($changes)) {
            return;
        }

        $subjectType = $activity->subject_type;
        if (! $subjectType || ! class_exists($subjectType)) {
            return;
        }

        // We use a dummy instance to check for relation methods
        $subjectModel = new $subjectType;

        foreach (['attributes', 'old'] as $key) {
            if (! isset($changes[$key]) || ! is_array($changes[$key])) {
                continue;
            }

            // We work on a copy of the array section
            $data = $changes[$key];

            foreach ($data as $attribute => $value) {
                // If it looks like a foreign key
                if (Str::endsWith($attribute, '_id') && $value !== null) {
                    $relationName = $this->guessRelationName($attribute);

                    if ($relationName && method_exists($subjectModel, $relationName)) {
                        try {
                            $relation = $subjectModel->$relationName();

                            // Check if it's a BelongsTo relation
                            if (method_exists($relation, 'getRelated')) {
                                $relatedModel = $relation->getRelated();
                                $relatedRecord = $relatedModel::find($value);

                                if ($relatedRecord) {
                                    $displayValue = $this->getRelatedDisplayName($relatedRecord);

                                    // Use the relation name as the key (e.g. 'module' instead of 'modul_id')
                                    $data[$relationName] = $displayValue;
                                    unset($data[$attribute]);
                                }
                            }
                        } catch (\Exception $e) {
                            continue;
                        }
                    }
                }
            }

            $changes[$key] = $data;
        }

        $activity->attribute_changes = $changes;
        $activity->properties = $changes;
    }

    /**
     * Guess the relation name based on the foreign key attribute.
     */
    protected function guessRelationName(string $attribute): ?string
    {
        $mappings = [
            'modul_id' => 'module',
            'module_id' => 'modul_mgt',
            'content_id' => 'content_mgt',
            'department_id' => 'department',
            'approver_id' => 'approver',
            'created_by' => 'creator',
            'last_modified_by' => 'modifier',
        ];

        if (isset($mappings[$attribute])) {
            return $mappings[$attribute];
        }

        return Str::beforeLast($attribute, '_id');
    }

    /**
     * Get a human-readable display name for the related record.
     */
    protected function getRelatedDisplayName($record): string
    {
        // Try common name fields
        $fields = ['module_name', 'name', 'title', 'label', 'email', 'nik'];

        foreach ($fields as $field) {
            if (isset($record->$field)) {
                return (string) $record->$field;
            }
        }

        // Special case for User name attribute/accessor
        if (method_exists($record, 'getNameAttribute') || isset($record->name)) {
            return $record->name;
        }

        if (isset($record->first_name)) {
            return trim($record->first_name.' '.($record->last_name ?? ''));
        }

        return (string) $record->id;
    }
}
