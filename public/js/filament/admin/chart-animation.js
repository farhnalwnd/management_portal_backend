/**
 * Chart.js Animation Restore Plugin for Filament
 *
 * Problem: In Filament's chart.js, `initChart()` calls:
 *   Chart.defaults.animation.duration = 0
 * This globally disables animations BEFORE `new Chart()` is called,
 * so all per-chart animation options (from PHP getOptions()) get overridden.
 *
 * Fix: Register a global Chart.js plugin that runs `beforeInit` and
 * restores animation settings from the raw options passed to the constructor
 * (accessible via `chart.config.options` before Chart.defaults are deep-merged).
 */
;(function () {
    window.filamentChartJsGlobalPlugins = window.filamentChartJsGlobalPlugins || []

    // Avoid double-registration on hot-reload / multiple script loads
    if (window.filamentChartJsGlobalPlugins.some(function (p) { return p.id === 'restoreAnimation' })) {
        return
    }

    window.filamentChartJsGlobalPlugins.push({
        id: 'restoreAnimation',

        /**
         * `beforeInit` fires after the Chart constructor merges options with
         * Chart.defaults, but `chart.config.options` still holds the RAW options
         * object passed to `new Chart(canvas, { options })` — before the deep merge.
         *
         * We use this to detect if the PHP widget explicitly set animation.duration > 0
         * and restore it on `chart.options` (the post-merge resolved object).
         */
        beforeInit: function (chart) {
            // chart.config.options = raw options from PHP widget getOptions()
            var rawAnimation = chart.config && chart.config.options && chart.config.options.animation

            if (!rawAnimation) {
                return
            }

            var rawDuration = rawAnimation.duration

            if (typeof rawDuration === 'number' && rawDuration > 0) {
                // Restore the animation options the developer intended
                chart.options.animation = Object.assign(
                    {},
                    chart.options.animation,
                    rawAnimation
                )
            }
        },
    })
})()
