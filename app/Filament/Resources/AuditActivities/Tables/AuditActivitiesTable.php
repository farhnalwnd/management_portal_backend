<?php

namespace App\Filament\Resources\AuditActivities\Tables;

use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AuditActivitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('log_name')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'user management' => 'info',
                        'featur mgt' => 'warning',
                        'access control' => 'danger',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('event')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('description')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('subject_type')
                    ->label('Model')
                    ->formatStateUsing(fn (string $state): string => str_replace('App\\Models\\', '', $state))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('causer.name')
                    ->label('User')
                    ->placeholder('System')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('exportExcel')
                    ->label('Export to Excel')
                    ->icon(Heroicon::OutlinedDocumentArrowDown)
                    ->color('success')
                    ->action(function () use ($table) {
                        $query = $table->getLivewire()->getFilteredTableQuery();
                        $records = $query->get();

                        return response()->streamDownload(function () use ($records) {
                            $spreadsheet = new Spreadsheet;
                            $sheet = $spreadsheet->getActiveSheet();

                            // Set headers
                            $headers = ['Log Name', 'Event', 'Description', 'Model', 'User', 'Date', 'Changes'];
                            foreach ($headers as $index => $header) {
                                $col = chr(65 + $index); // A, B, C, D, E, F, G
                                $sheet->setCellValue($col.'1', $header);
                            }

                            // Style headers: Bold, white text, primary background color (#4DA8CF), secondary color accent border (#3F8F81)
                            $headerStyle = [
                                'font' => [
                                    'bold' => true,
                                    'color' => ['rgb' => 'FFFFFF'],
                                    'name' => 'Segoe UI',
                                    'size' => 11,
                                ],
                                'fill' => [
                                    'fillType' => Fill::FILL_SOLID,
                                    'startColor' => ['rgb' => '4DA8CF'], // Primary brand color
                                ],
                                'alignment' => [
                                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                                    'vertical' => Alignment::VERTICAL_CENTER,
                                ],
                                'borders' => [
                                    'allBorders' => [
                                        'borderStyle' => Border::BORDER_THIN,
                                        'color' => ['rgb' => 'B9D6E5'],
                                    ],
                                    'bottom' => [
                                        'borderStyle' => Border::BORDER_MEDIUM,
                                        'color' => ['rgb' => '3F8F81'], // Secondary brand color
                                    ],
                                ],
                            ];
                            $sheet->getStyle('A1:G1')->applyFromArray($headerStyle);
                            $sheet->getRowDimension(1)->setRowHeight(28);

                            // Populate data
                            $row = 2;
                            foreach ($records as $record) {
                                $modelName = str_replace('App\\Models\\', '', $record->subject_type ?? '');
                                $userName = $record->causer?->name ?? 'System';

                                // Format JSON properties/attributes to neat multi-line text
                                $changes = $record->attribute_changes;
                                if ($changes instanceof \Illuminate\Support\Collection) {
                                    $changes = $changes->toArray();
                                } else {
                                    $changes = (array) $changes;
                                }

                                $formattedChanges = '';
                                if (isset($changes['attributes']) && is_array($changes['attributes'])) {
                                    $formattedChanges .= "[New Data]\n";
                                    foreach ($changes['attributes'] as $key => $val) {
                                        $valStr = is_array($val) ? json_encode($val, JSON_UNESCAPED_SLASHES) : (string) $val;
                                        $formattedChanges .= "{$key}: {$valStr}\n";
                                    }
                                }
                                if (isset($changes['old']) && is_array($changes['old'])) {
                                    if (! empty($formattedChanges)) {
                                        $formattedChanges .= "\n";
                                    }
                                    $formattedChanges .= "[Old Data]\n";
                                    foreach ($changes['old'] as $key => $val) {
                                        $valStr = is_array($val) ? json_encode($val, JSON_UNESCAPED_SLASHES) : (string) $val;
                                        $formattedChanges .= "{$key}: {$valStr}\n";
                                    }
                                }
                                $formattedChanges = trim($formattedChanges);

                                $sheet->setCellValue('A'.$row, $record->log_name);
                                $sheet->setCellValue('B'.$row, $record->event);
                                $sheet->setCellValue('C'.$row, $record->description);
                                $sheet->setCellValue('D'.$row, $modelName);
                                $sheet->setCellValue('E'.$row, $userName);
                                $sheet->setCellValue('F'.$row, $record->created_at?->toDateTimeString());
                                $sheet->setCellValue('G'.$row, $formattedChanges);

                                // Zebra striping: alternate background colors using soft blue/white
                                $isEven = ($row % 2 === 0);
                                $rowBgColor = $isEven ? 'E0F2FE' : 'FFFFFF'; // E0F2FE is medical-primary-soft

                                $rowStyle = [
                                    'font' => [
                                        'name' => 'Segoe UI',
                                        'size' => 10,
                                    ],
                                    'fill' => [
                                        'fillType' => Fill::FILL_SOLID,
                                        'startColor' => ['rgb' => $rowBgColor],
                                    ],
                                    'borders' => [
                                        'allBorders' => [
                                            'borderStyle' => Border::BORDER_THIN,
                                            'color' => ['rgb' => 'D0E1ED'],
                                        ],
                                    ],
                                    'alignment' => [
                                        'vertical' => Alignment::VERTICAL_CENTER,
                                    ],
                                ];

                                $sheet->getStyle("A{$row}:G{$row}")->applyFromArray($rowStyle);

                                // Enable wrap text for the Changes/Attributes column (G)
                                $sheet->getStyle("G{$row}")->getAlignment()->setWrapText(true);
                                $sheet->getRowDimension($row)->setRowHeight(-1);

                                $row++;
                            }

                            // Auto-fit column widths for columns A to F
                            foreach (range('A', 'F') as $col) {
                                $sheet->getColumnDimension($col)->setAutoSize(true);
                            }
                            // Column G has wrapped multi-line text, so set a fixed readable width
                            $sheet->getColumnDimension('G')->setWidth(50);

                            $writer = new Xlsx($spreadsheet);
                            $writer->save('php://output');
                        }, 'audit_activities_'.now()->format('Y-m-d_H-i-s').'.xlsx');
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
