<!-- Google Analytics Stats -->
<?php if ($config->setting_dashboard_GA_stats): ?>
<div class="column-card mb-5">
    <div class="card-header mb-0 pb-0">
        <div class="card-title"><h6>Google Analytics</h6></div>
        <div class="form-group card-options">
            <select class="px-1" id="analytics-stats" name="stats-date" onchange="ajax_analytics(this.value)">
                <option value="today">Today</option>
                <option value="yesterday">Yesterday</option>
                <option value="7daysAgo" selected>Last 7 Days</option>
                <option value="14daysAgo">Last 14 Days</option>
                <option value="30daysAgo">Last 30 Days</option>
                <option value="90daysAgo">Last 90 Days</option>
                <option value="365daysAgo">One Year</option>
            </select>
        </div>
    </div>
    <div class="card-body">
        <div id="ajax-ga-stats" style="width: 100%; min-height: 250px;"></div>
    </div>
</div>
<?php endif; ?>
<!-- End Google Analytics Stats -->