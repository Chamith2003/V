<?php
class systemoverviewcontroller {
    private $model;

    public function __construct($systemoverviewmodel) {
        $this->model = $systemoverviewmodel;
    }

    public function showSystemOverview() {
        // Fetch all analytics data from the model
        $stats = $this->model->getSystemStats();
        $monthlyData = $this->model->getMonthlyTrends();
        $monthlyDataYear = $this->model->getMonthlyTrendsYear();
        $monthlyDataAllTime = $this->model->getMonthlyTrendsAllTime();
        $citiesData = $this->model->getMostActiveCities();
        $categoriesData = $this->model->getEventCategories();
        $topVolunteers = $this->model->getTopVolunteers();
        $topSponsors = $this->model->getTopSponsors();
        $growthData = $this->model->getSystemGrowth();
        $recentActivities = $this->model->getRecentActivities();
        
        // Include the view with data
        include 'View/admin/systemoverview/systemoverviewadminpanel.php';
    }

    public function generateReport() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reportType = $_POST['report_type'] ?? '';
            $fromDate = $_POST['from_date'] ?? '';
            $toDate = $_POST['to_date'] ?? '';
            $options = $_POST['options'] ?? [];
            $format = $_POST['export_format'] ?? 'csv';

            if (empty($reportType) || empty($fromDate) || empty($toDate)) {
                // Return generic error or redirect
                header("Location: /V/router.php?module=admin&action=systemoverview");
                exit();
            }

            // Fetch data from model
            $reportData = $this->model->getReportData($reportType, $fromDate, $toDate, $options);

            if ($format === 'html') {
                include 'View/admin/reports/reporttemplate.php';
                exit();
            }
        }
        
        header("Location: /V/router.php?module=admin&action=systemoverview");
        exit();
    }
}
?>