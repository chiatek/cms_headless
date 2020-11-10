<!-- Google Analytics Chart -->
<?php if ($config->setting_dashboard_GA_chart): ?>
<input type="hidden" id="site-url" value="<?php echo site_url('dashboard/index/'); ?>" />

<div class="column-card mb-5">
    <div class="card-header mb-0 pb-0">
        <div class="card-title"><h6>Google Analytics</h6></div>
        <div class="form-group card-options">
            <select class="px-1" id="analytics-date" name="date" onchange="ajax_data(this.value, this.name)">
                <option value="today">Today</option>
                <option value="yesterday">Yesterday</option>
                <option value="7daysAgo" selected>Last 7 Days</option>
                <option value="14daysAgo">Last 14 Days</option>
                <option value="30daysAgo">Last 30 Days</option>
                <option value="90daysAgo">Last 90 Days</option>
                <option value="365daysAgo">One Year</option>
            </select>
            <select class="px-1" id="analytics-metric" name="metrics" onchange="ajax_data(this.value, this.name)">
                <option value="ga:sessions" selected>Sessions</option>
                <option value="ga:users">Users</option>
                <option value="ga:organicSearches">Organic</option>
                <option value="ga:pageViews">Page Views</option>
                <option value="ga:bounceRate">Bounce Rate</option>
            </select>
        </div>
    </div>
    <div class="card-body">
        <div id="ajax-ga-chart"></div>
    </div>
</div>
<?php endif; ?>
<!-- End Google Analytics Chart -->