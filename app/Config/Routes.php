<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Dashboard::redirect'); jika ada pengecekan // pengecekan level sudah di layout index menurut sidebar
$routes->get('/', 'Dashboard::index');

//routes dashboard
$routes->get('dashboard', 'Dashboard::index');
$routes->get('dashboard/dashboard_employee', 'Dashboard::dashboard_employee');
$routes->get('dashboard/late', 'Dashboard::late');
$routes->get('dashboard/absent', 'Dashboard::absent');
$routes->get('dashboard/count_makan', 'Dashboard::count_makan');
$routes->get('dashboard/order_catering', 'Dashboard::order_catering');
$routes->get('dashboard/grafik_karyawan', 'Dashboard::grafik_karyawan');
$routes->get('dashboard/notifikasi', 'Dashboard::notifikasi');
$routes->get('dashboard/absent_plant/(:num)/(:num)', 'Dashboard::absent_plant/$1/$2');
$routes->get('dashboard/absent_employee/(:segment)/(:segment)/(:segment)/(:segment)/(:segment)', 'Dashboard::absent_employee/$1/$2/$3/$4/$5');

$routes->get('dashboard/admin', 'Dashboard::admin');
$routes->get('dashboard/adminhr', 'Dashboard::adminhr');
$routes->get('dashboard/adminga', 'Dashboard::adminga');

$routes->post('dashboard/exportChartPdf', 'Dashboard::exportChartPdf');
$routes->get('dashboard/export_percentage/(:segment)', 'Dashboard::export_percentage/$1');

$routes->get('dashboard/chartAbsentAjax', 'Dashboard::chartAbsentAjax');
$routes->get('dashboard/get-chart-employee', 'Dashboard::getChartEmployee');
$routes->get('dashboard/chartEmployeePerformance', 'Dashboard::chartEmployeePerformance');
$routes->get('dashboard/chartDivision', 'Dashboard::chartDivision');
$routes->get('dashboard/chartMonthlyAbsentTrend', 'Dashboard::chartMonthlyAbsentTrend');
$routes->get('dashboard/chartAbsentTrend', 'Dashboard::chartAbsentTrend');

//routes welcome board
$routes->get('welcome_board', 'WelcomeBoard::index');
$routes->get('welcome_board/add', 'WelcomeBoard::add');
$routes->post('welcome_board/save', 'WelcomeBoard::save');
$routes->get('welcome_board/active/(:segment)', 'WelcomeBoard::active/$1');
$routes->get('welcome_board/non_active/(:segment)', 'WelcomeBoard::non_active/$1');
$routes->get('welcome_board/view', 'WelcomeBoard::view');

//count food
$routes->get('count_food', 'CountFood::index');
$routes->post('count_food/generate', 'CountFood::generate');
$routes->post('count_food/update_status', 'CountFood::update_status');
$routes->get('count_food/data', 'CountFood::data');
$routes->post('count_food/search', 'CountFood::search');
$routes->get('count_food/cardFood', 'CountFood::cardFood');
$routes->get('count_food/print/(:segment)', 'CountFood::print/$1');
$routes->get('count_food/printAll', 'CountFood::printAll');

$routes->get('tools/create-auth', 'Tools::createAuth');
$routes->get('tools/auth-key', 'Tools::authKey');

//routes Guest
$routes->get('guest', 'Guest::index');
$routes->get('guest/add', 'Guest::add');
$routes->post('guest/save', 'Guest::save');
$routes->get('guest/edit/(:segment)', 'Guest::edit/$1');
$routes->post('guest/update/(:segment)', 'Guest::update/$1');
$routes->get('guest/delete/(:num)', 'Guest::delete/$1');

//routes Genereal Affairs
$routes->get('general_affairs/sim', 'GeneralAffairs::sim');
$routes->get('general_affairs/sim_add', 'GeneralAffairs::sim_add');
$routes->post('general_affairs/sim_save', 'GeneralAffairs::sim_save');
$routes->get('general_affairs/sim_edit/(:segment)', 'GeneralAffairs::sim_edit/$1');
$routes->post('general_affairs/sim_update/(:segment)', 'GeneralAffairs::sim_update/$1');
$routes->get('general_affairs/sim_delete/(:num)', 'GeneralAffairs::sim_delete/$1');

$routes->get('general_affairs/stnk', 'GeneralAffairs::stnk');
$routes->get('general_affairs/stnk_add', 'GeneralAffairs::stnk_add');
$routes->post('general_affairs/stnk_save', 'GeneralAffairs::stnk_save');
$routes->get('general_affairs/stnk_edit/(:segment)', 'GeneralAffairs::stnk_edit/$1');
$routes->post('general_affairs/stnk_update/(:segment)', 'GeneralAffairs::stnk_update/$1');
$routes->get('general_affairs/stnk_delete/(:num)', 'GeneralAffairs::stnk_delete/$1');

$routes->get('general_affairs/stiker_kendaraan', 'GeneralAffairs::stiker_kendaraan');
$routes->get('general_affairs/print/(:segment)', 'GeneralAffairs::print/$1');
$routes->get('general_affairs/stikerPrintAll/(:num)', 'GeneralAffairs::stikerPrintAll/$1');
$routes->post('general_affairs/search_stiker', 'GeneralAffairs::search_stiker');
$routes->post('general_affairs/print_checked', 'GeneralAffairs::print_checked');

//routes account
$routes->get('account', 'Account::index');
$routes->get('account/edit/(:segment)', 'Account::edit/$1');
$routes->post('account/update/(:segment)', 'Account::update/$1');
$routes->get('account/delete/(:num)', 'Account::delete/$1');

//routes Employee
$routes->get('employee', 'Employee::index');
$routes->get('employee/add', 'Employee::add');
$routes->post('employee/save', 'Employee::save');
$routes->get('employee/edit/(:segment)', 'Employee::edit/$1');
$routes->post('employee/update/(:num)', 'Employee::update/$1');
$routes->get('employee/delete/(:num)', 'Employee::delete/$1');
$routes->get('employee/details/(:num)', 'Employee::details/$1');
$routes->get('employee/details2/(:num)', 'Employee::details2/$1');
$routes->get('employee/print/(:segment)', 'Employee::print/$1');
$routes->get('employee/employee_division/(:segment)', 'Employee::employee_division/$1');
$routes->get('employee/employee_division_edit/(:segment)', 'Employee::employee_division_edit/$1');
$routes->post('employee/employee_division_update', 'Employee::employee_division_update');

$routes->post('employee/export_excel', 'Employee::export_excel');
$routes->post('employee/search', 'Employee::search');
$routes->get('employee/printAllCard', 'Employee::printAllCard');
$routes->get('employee/printCard/(:segment)', 'Employee::printCard/$1');

$routes->get('employee/schedule', 'Employee::schedule');
$routes->get('employee/schedule_add/(:segment)', 'Employee::schedule_add/$1');
$routes->post('employee/schedule_save', 'Employee::schedule_save');
$routes->get('employee/schedule_generate', 'Employee::schedule_generate');
$routes->get('employee/generate_schedule', 'Employee::generate_schedule');
$routes->post('employee/save_generate_schedule', 'Employee::save_generate_schedule');

$routes->get('employee/upload/(:num)', 'Employee::upload/$1');
$routes->post('employee/upload_save/(:num)', 'Employee::upload_save/$1');
$routes->get('employee/delete_file/(:num)/(:any)', 'Employee::delete_file/$1/$2');

$routes->get('employee/resign', 'Employee::resign');
$routes->get('employee/resign_add', 'Employee::resign_add');
$routes->post('employee/resign_save', 'Employee::resign_save');
$routes->get('employee/resign_edit/(:segment)', 'Employee::resign_edit/$1');
$routes->post('employee/resign_update/(:segment)', 'Employee::resign_update/$1');
$routes->get('employee/resign_delete/(:segment)', 'Employee::resign_delete/$1');

$routes->get('employee/uploads/(:num)', 'Employee::uploads/$1');
$routes->post('employee/uploads_save', 'Employee::uploads_save');
$routes->get('employee/download_file/(:num)', 'Employee::download_file/$1');
$routes->get('employee/deleted_file/(:num)/(:num)', 'Employee::deleted_file/$1/$2');

$routes->get('employee/employeeAbsentHistoryAjax', 'Employee::employeeAbsentHistoryAjax');

//routes attendance
$routes->get('attendance', 'Attendance::index');
$routes->get('attendance/download/(:segment)', 'Attendance::download/$1');
$routes->get('attendance/download_all', 'Attendance::download_all');
$routes->post('attendance/download_log', 'Attendance::download_log');
$routes->post('attendance/search', 'Attendance::search');
$routes->get('attendance/not_absent/(:segment)', 'Attendance::not_absent/$1');
$routes->get('attendance/form_absent/(:segment)', 'Attendance::form_absent/$1');
$routes->post('attendance/save_absent', 'Attendance::save_absent');
$routes->get('attendance/report', 'Attendance::report');
$routes->get('attendance/report_user', 'Attendance::report_user');
$routes->post('attendance/search_report_user', 'Attendance::search_report_user');
$routes->get('attendance/report_user_export/(:segment)/(:segment)/(:segment)', 'Attendance::report_user_export/$1/$2/$3');
$routes->post('attendance/search_report', 'Attendance::search_report');
$routes->get('attendance/report_export/(:segment)/(:segment)/(:segment)/(:segment)/(:segment)/(:segment)', 'Attendance::report_export/$1/$2/$3/$4/$5/$6');
$routes->get('attendance/form_absent_report/(:segment)/(:segment)', 'Attendance::form_absent_report/$1/$2');
$routes->post('attendance/save_absent_report', 'Attendance::save_absent_report');

$routes->get('attendance/absent', 'Attendance::absent');
$routes->post('attendance/absent_search', 'Attendance::absent_search');
$routes->get('attendance/absent_add', 'Attendance::absent_add');
$routes->post('attendance/absent_save', 'Attendance::absent_save');
$routes->get('attendance/absent_edit/(:num)', 'Attendance::absent_edit/$1');
$routes->post('attendance/absent_update', 'Attendance::absent_update');
$routes->get('attendance/absent_delete/(:num)', 'Attendance::absent_delete/$1');

$routes->get('attendance/employee_late', 'Attendance::employee_late');
$routes->post('attendance/employee_late_search', 'Attendance::employee_late_search');
$routes->get('attendance/employee_late_add', 'Attendance::employee_late_add');
$routes->post('attendance/employee_late_save', 'Attendance::employee_late_save');
$routes->get('attendance/employee_late_edit/(:num)', 'Attendance::employee_late_edit/$1');
$routes->post('attendance/employee_late_update', 'Attendance::employee_late_update');
$routes->get('attendance/employee_late_delete/(:num)', 'Attendance::employee_late_delete/$1');

$routes->post('attendance/report_export', 'Attendance::report_export');
$routes->post('attendance/report_user_export', 'Attendance::report_user_export');

$routes->get('attendance/report_department', 'Attendance::report_department');
$routes->post('attendance/search_report_department', 'Attendance::search_report_department');
$routes->post('attendance/report_department_export', 'Attendance::report_department_export');


$routes->get('attendance/reportmonthlydepartment', 'Attendance::reportmonthlydepartment');
$routes->post('attendance/searchreportmonyhlydepartment', 'Attendance::searchreportmonyhlydepartment');
$routes->post('attendance/export_report_monthly_department', 'Attendance::export_report_monthly_department');

$routes->get('attendance/employee_late_today/(:num)', 'Attendance::employee_late_today/$1');

$routes->get('attendance/present_today', 'Attendance::present_today');
$routes->get('attendance/absent_today/(:num)', 'Attendance::absent_today/$1');


$routes->post('employee/getRegencies', 'Employee::getRegencies');
$routes->post('employee/getDistricts', 'Employee::getDistricts');
$routes->post('employee/getVillages', 'Employee::getVillages');


//DATA MANAGEMENT
//routes company
$routes->get('company', 'Company::index');
$routes->get('company/add', 'Company::add');
$routes->post('company/save', 'Company::save');
$routes->get('company/edit/(:segment)', 'Company::edit/$1');
$routes->post('company/update/(:segment)', 'Company::update/$1');
$routes->get('company/delete/(:num)', 'Company::delete/$1');

//route division
$routes->get('division', 'Division::index');
$routes->get('division/add', 'Division::add');
$routes->post('division/save', 'Division::save');
$routes->get('division/edit/(:segment)', 'Division::edit/$1');
$routes->post('division/update/(:segment)', 'Division::update/$1');
$routes->get('division/delete/(:num)', 'Division::delete/$1');

//route section
$routes->get('section', 'Section::index');
$routes->get('section/add', 'Section::add');
$routes->post('section/save', 'Section::save');
$routes->get('section/edit/(:segment)', 'Section::edit/$1');
$routes->post('section/update/(:segment)', 'Section::update/$1');
$routes->get('section/delete/(:num)', 'Section::delete/$1');

//route position
$routes->get('position', 'Position::index');
$routes->get('position/add', 'Position::add');
$routes->post('position/save', 'Position::save');
$routes->get('position/edit/(:segment)', 'Position::edit/$1');
$routes->post('position/update/(:segment)', 'Position::update/$1');
$routes->get('position/delete/(:num)', 'Position::delete/$1');

//routes plant
$routes->get('plant', 'Plant::index');
$routes->get('plant/add', 'Plant::add');
$routes->post('plant/save', 'Plant::save');
$routes->get('plant/edit/(:segment)', 'Plant::edit/$1');
$routes->post('plant/update/(:segment)', 'Plant::update/$1');
$routes->get('plant/delete/(:num)', 'Plant::delete/$1');

//routes group
$routes->get('employee_group', 'EmployeeGroup::index');
$routes->get('employee_group/add', 'EmployeeGroup::add');
$routes->post('employee_group/save', 'EmployeeGroup::save');
$routes->get('employee_group/edit/(:segment)', 'EmployeeGroup::edit/$1');
$routes->post('employee_group/update/(:segment)', 'EmployeeGroup::update/$1');
$routes->get('employee_group/delete/(:num)', 'EmployeeGroup::delete/$1');

//route blood type
$routes->get('blood_type', 'BloodType::index');
$routes->get('blood_type/add', 'BloodType::add');
$routes->post('blood_type/save', 'BloodType::save');
$routes->get('blood_type/edit/(:segment)', 'BloodType::edit/$1');
$routes->post('blood_type/update/(:segment)', 'BloodType::update/$1');
$routes->get('blood_type/delete/(:num)', 'BloodType::delete/$1');

//route product synchronization
$routes->get('product_synchronization', 'ProductSynchronization::index');
$routes->get('product_synchronization/add', 'ProductSynchronization::add');
$routes->post('product_synchronization/save', 'ProductSynchronization::save');
$routes->get('product_synchronization/edit/(:segment)', 'ProductSynchronization::edit/$1');
$routes->post('product_synchronization/update/(:segment)', 'ProductSynchronization::update/$1');
$routes->get('product_synchronization/delete/(:num)', 'ProductSynchronization::delete/$1');

//route education
$routes->get('education', 'Education::index');
$routes->get('education/add', 'Education::add');
$routes->post('education/save', 'Education::save');
$routes->get('education/edit/(:segment)', 'Education::edit/$1');
$routes->post('education/update/(:segment)', 'Education::update/$1');
$routes->get('education/delete/(:num)', 'Education::delete/$1');

//route employee status
$routes->get('employee_status', 'EmployeeStatus::index');
$routes->get('employee_status/add', 'EmployeeStatus::add');
$routes->post('employee_status/save', 'EmployeeStatus::save');
$routes->get('employee_status/edit/(:segment)', 'EmployeeStatus::edit/$1');
$routes->post('employee_status/update/(:segment)', 'EmployeeStatus::update/$1');
$routes->get('employee_status/delete/(:num)', 'EmployeeStatus::delete/$1');

$routes->get('employee/upload_ktp/(:num)', 'Employee::upload_ktp/$1');
$routes->get('employee/upload_kk/(:num)', 'Employee::upload_kk/$1');

//route tax status
$routes->get('tax_status', 'TaxStatus::index');
$routes->get('tax_status/add', 'TaxStatus::add');
$routes->post('tax_status/save', 'TaxStatus::save');
$routes->get('tax_status/edit/(:segment)', 'TaxStatus::edit/$1');
$routes->post('tax_status/update/(:segment)', 'TaxStatus::update/$1');
$routes->get('tax_status/delete/(:num)', 'TaxStatus::delete/$1');

//route gender
$routes->get('gender', 'Gender::index');
$routes->get('gender/add', 'Gender::add');
$routes->post('gender/save', 'Gender::save');
$routes->get('gender/edit/(:segment)', 'Gender::edit/$1');
$routes->post('gender/update/(:segment)', 'Gender::update/$1');
$routes->get('gender/delete/(:num)', 'Gender::delete/$1');

//route religion
$routes->get('religion', 'Religion::index');
$routes->get('religion/add', 'Religion::add');
$routes->post('religion/save', 'Religion::save');
$routes->get('religion/edit/(:segment)', 'Religion::edit/$1');
$routes->post('religion/update/(:segment)', 'Religion::update/$1');
$routes->get('religion/delete/(:num)', 'Religion::delete/$1');

//route marriage status
$routes->get('marriage_status', 'MarriageStatus::index');
$routes->get('marriage_status/add', 'MarriageStatus::add');
$routes->post('marriage_status/save', 'MarriageStatus::save');
$routes->get('marriage_status/edit/(:segment)', 'MarriageStatus::edit/$1');
$routes->post('marriage_status/update/(:segment)', 'MarriageStatus::update/$1');
$routes->get('marriage_status/delete/(:num)', 'MarriageStatus::delete/$1');

//route absent type
$routes->get('absent_type', 'AbsentType::index');
$routes->get('absent_type/add', 'AbsentType::add');
$routes->post('absent_type/save', 'AbsentType::save');
$routes->get('absent_type/edit/(:segment)', 'AbsentType::edit/$1');
$routes->post('absent_type/update/(:segment)', 'AbsentType::update/$1');
$routes->get('absent_type/delete/(:num)', 'AbsentType::delete/$1');

//route bank
$routes->get('bank', 'Bank::index');
$routes->get('bank/add', 'Bank::add');
$routes->post('bank/save', 'Bank::save');
$routes->get('bank/edit/(:segment)', 'Bank::edit/$1');
$routes->post('bank/update/(:segment)', 'Bank::update/$1');
$routes->get('bank/delete/(:num)', 'Bank::delete/$1');

//route uniform size
$routes->get('uniform_size', 'UniformSize::index');
$routes->get('uniform_size/add', 'UniformSize::add');
$routes->post('uniform_size/save', 'UniformSize::save');
$routes->get('uniform_size/edit/(:segment)', 'UniformSize::edit/$1');
$routes->post('uniform_size/update/(:segment)', 'UniformSize::update/$1');
$routes->get('uniform_size/delete/(:num)', 'UniformSize::delete/$1');

//route shoes size
$routes->get('shoes_size', 'ShoesSize::index');
$routes->get('shoes_size/add', 'ShoesSize::add');
$routes->post('shoes_size/save', 'ShoesSize::save');
$routes->get('shoes_size/edit/(:segment)', 'ShoesSize::edit/$1');
$routes->post('shoes_size/update/(:segment)', 'ShoesSize::update/$1');
$routes->get('shoes_size/delete/(:num)', 'ShoesSize::delete/$1');

//route attendance machine
$routes->get('attendance_machine', 'AttendanceMachine::index');
$routes->get('attendance_machine/add', 'AttendanceMachine::add');
$routes->post('attendance_machine/save', 'AttendanceMachine::save');
$routes->get('attendance_machine/edit/(:segment)', 'AttendanceMachine::edit/$1');
$routes->post('attendance_machine/update/(:segment)', 'AttendanceMachine::update/$1');
$routes->get('attendance_machine/delete/(:num)', 'AttendanceMachine::delete/$1');

//route shift
$routes->get('shift', 'Shift::index');
$routes->get('shift/add', 'Shift::add');
$routes->post('shift/save', 'Shift::save');
$routes->get('shift/edit/(:segment)', 'Shift::edit/$1');
$routes->post('shift/update/(:segment)', 'Shift::update/$1');
$routes->get('shift/delete/(:num)', 'Shift::delete/$1');

//route working hours
$routes->get('working_hours', 'WorkingHours::index');
$routes->get('working_hours/add', 'WorkingHours::add');
$routes->post('working_hours/save', 'WorkingHours::save');
$routes->get('working_hours/edit/(:segment)', 'WorkingHours::edit/$1');
$routes->post('working_hours/update/(:segment)', 'WorkingHours::update/$1');
$routes->get('working_hours/delete/(:num)', 'WorkingHours::delete/$1');

//route working days
$routes->get('working_days', 'WorkingDays::index');
$routes->get('working_days/add', 'WorkingDays::add');
$routes->post('working_days/save', 'WorkingDays::save');
$routes->get('working_days/edit/(:segment)/(:segment)', 'WorkingDays::edit/$1/$2');
$routes->post('working_days/update/(:segment)/(:segment)', 'WorkingDays::update/$1/$2');
$routes->get('working_days/delete/(:num)/(:num)', 'WorkingDays::delete/$1/$2');

//routes contract
$routes->get('contract', 'Contract::index');
$routes->post('contract/search', 'Contract::search');
$routes->get('contract/add', 'Contract::add');
$routes->post('contract/save', 'Contract::save');
$routes->get('contract/edit/(:num)', 'Contract::edit/$1');
$routes->post('contract/update', 'Contract::update');
$routes->get('contract/delete/(:num)', 'Contract::delete/$1');

$routes->get('contract/employee/(:segment)', 'Contract::employee/$1');
$routes->get('contract/add_employee/(:segment)', 'Contract::add_employee/$1');
$routes->post('contract/save_employee', 'Contract::save_employee');
$routes->get('contract/edit_employee/(:num)', 'Contract::edit_employee/$1');
$routes->post('contract/update_employee', 'Contract::update_employee');
$routes->get('contract/delete_employee/(:num)/(:num)', 'Contract::delete_employee/$1/$2');

$routes->get('contract/print/(:num)', 'Contract::print/$1');

//routes overtime
$routes->get('overtime', 'Overtime::index');
$routes->post('overtime/search', 'Overtime::search');
$routes->get('overtime/add', 'Overtime::add');
$routes->post('overtime/save', 'Overtime::save');
$routes->get('overtime/edit/(:num)', 'Overtime::edit/$1');
$routes->post('overtime/update', 'Overtime::update');
$routes->get('overtime/delete/(:num)', 'Overtime::delete/$1');
$routes->match(['get', 'post'], 'overtime/report', 'Overtime::report');
$routes->match(['get', 'post'], 'overtime/report_user', 'Overtime::report_user');
$routes->post('overtime/search_report', 'Overtime::search_report');
$routes->post('overtime/export', 'Overtime::export');
$routes->post('overtime/export2', 'Overtime::export2');
$routes->get('overtime/form', 'Overtime::form');
$routes->get('overtime/form_add', 'Overtime::form_add');
$routes->post('overtime/form_save', 'Overtime::form_save');
$routes->post('overtime/update_status', 'Overtime::update_status');
$routes->get('overtime/form_edit/(:segment)', 'Overtime::form_edit/$1');
$routes->get('overtime/delete_employee/(:segment)/(:segment)', 'Overtime::delete_employee/$1/$2');
$routes->post('overtime/form_update/(:segment)', 'Overtime::form_update/$1');
$routes->get('overtime/form_delete/(:segment)', 'Overtime::form_delete/$1');
$routes->get('overtime/form_detail/(:segment)', 'Overtime::form_detail/$1');
$routes->get('overtime/form_print/(:segment)', 'Overtime::form_print/$1');

//routes Ticket
$routes->get('ticket', 'Ticket::index');
$routes->post('ticket/search', 'Ticket::search');
$routes->get('ticket/add', 'Ticket::add');
$routes->post('ticket/save', 'Ticket::save');
$routes->get('ticket/edit/(:num)', 'Ticket::edit/$1');
$routes->post('ticket/update', 'Ticket::update');
$routes->get('ticket/delete/(:num)', 'Ticket::delete/$1');
$routes->get('ticket/closed/(:num)', 'Ticket::closed/$1');

//routes inventory
$routes->get('inventory/hardware', 'Inventory::hardware');
$routes->post('inventory/hardware_search', 'Inventory::hardware_search');
$routes->get('inventory/hardware_add', 'Inventory::hardware_add');
$routes->post('inventory/hardware_save', 'Inventory::hardware_save');
$routes->get('inventory/brand-by-category/(:num)', 'Inventory::getBrandByCategory/$1');
$routes->get('inventory/hardware_edit/(:num)', 'Inventory::hardware_edit/$1');
$routes->post('inventory/hardware_update', 'Inventory::hardware_update');
$routes->get('inventory/hardware_delete/(:num)', 'Inventory::hardware_delete/$1');

$routes->get('inventory/software', 'Inventory::software');
$routes->post('inventory/software_search', 'Inventory::software_search');
$routes->get('inventory/software_add', 'Inventory::software_add');
$routes->post('inventory/software_save', 'Inventory::software_save');
$routes->get('inventory/software_edit/(:num)', 'Inventory::software_edit/$1');
$routes->post('inventory/software_update', 'Inventory::software_update');
$routes->get('inventory/software_delete/(:num)', 'Inventory::software_delete/$1');

$routes->get('inventory/network', 'Inventory::network');
$routes->post('inventory/network_search', 'Inventory::network_search');
$routes->get('inventory/network_add', 'Inventory::network_add');
$routes->post('inventory/network_save', 'Inventory::network_save');
$routes->get('inventory/network_edit/(:num)', 'Inventory::network_edit/$1');
$routes->post('inventory/network_update', 'Inventory::network_update');
$routes->get('inventory/network_delete/(:num)', 'Inventory::network_delete/$1');

//hardware category
$routes->get('hardware_category', 'HardwareCategory::index');
$routes->get('hardware_category/add', 'HardwareCategory::add');
$routes->post('hardware_category/save', 'HardwareCategory::save');
$routes->get('hardware_category/edit/(:segment)', 'HardwareCategory::edit/$1');
$routes->post('hardware_category/update/(:segment)', 'HardwareCategory::update/$1');
$routes->get('hardware_category/delete/(:num)', 'HardwareCategory::delete/$1');

//hardware brand
$routes->get('hardware_brand', 'HardwareBrand::index');
$routes->get('hardware_brand/add', 'HardwareBrand::add');
$routes->post('hardware_brand/save', 'HardwareBrand::save');
$routes->get('hardware_brand/edit/(:segment)', 'HardwareBrand::edit/$1');
$routes->post('hardware_brand/update/(:segment)', 'HardwareBrand::update/$1');
$routes->get('hardware_brand/delete/(:num)', 'HardwareBrand::delete/$1');

//Inventory Category
$routes->get('inventory_category', 'InventoryCategories::index');
$routes->get('inventory_category/add', 'InventoryCategories::add');
$routes->post('inventory_category/save', 'InventoryCategories::save');
$routes->get('inventory_category/edit/(:segment)', 'InventoryCategories::edit/$1');
$routes->get('inventory_category/delete/(:segment)', 'InventoryCategories::delete/$1');
$routes->post('inventory_category/update/(:segment)', 'InventoryCategories::update/$1');

//Inventory Item
$routes->get('inventory_items', 'InventoryItems::index');
$routes->get('inventory_items/add', 'InventoryItems::add');
$routes->get('inventory_items/edit/(:segment)', 'InventoryItems::edit/$1');
$routes->post('inventory_items/save', 'InventoryItems::save');
$routes->post('inventory_items/update', 'InventoryItems::update');
$routes->get('inventory_items/delete/(:segment)', 'InventoryItems::delete/$1');

//Inventory Transactions IN
$routes->get('inventory_in', 'InventoryTransactionsIn::index');
$routes->get('inventory_in/add', 'InventoryTransactionsIn::add');
$routes->post('inventory_in/save', 'InventoryTransactionsIn::save');
$routes->get('inventory_in/edit/(:segment)', 'InventoryTransactionsIn::edit/$1');
$routes->post('inventory_in/update', 'InventoryTransactionsIn::update');
$routes->get('inventory_in/delete/(:segment)', 'InventoryTransactionsIn::delete/$1');

//Inventory Transactions OUT
$routes->get('inventory_out', 'InventoryTransactionsOut::index');
$routes->get('inventory_out/add', 'InventoryTransactionsOut::add');
$routes->post('inventory_out/save', 'InventoryTransactionsOut::save');
$routes->get('inventory_out/edit/(:segment)', 'InventoryTransactionsOut::edit/$1');
$routes->post('inventory_out/update', 'InventoryTransactionsOut::update');
$routes->get('inventory_out/delete/(:segment)', 'InventoryTransactionsOut::delete/$1');

$routes->get('inventory_stock_opname', 'InventoryStockOpname::index');
$routes->get('inventory_stock_opname/add', 'InventoryStockOpname::add');
$routes->get('inventory_stock_opname/edit/(:segment)', 'InventoryStockOpname::edit/$1');
$routes->post('inventory_stock_opname/save/(:segment)', 'InventoryStockOpname::save/$1');
$routes->get('inventory_stock_opname/delete/(:segment)', 'InventoryStockOpname::delete/$1');
$routes->get('inventory_stock_opname/details/(:segment)', 'InventoryStockOpname::details/$1');
$routes->get('inventory_stock_opname/print/(:segment)', 'InventoryStockOpname::print/$1');
$routes->get('inventory_stock_opname/print_empty', 'InventoryStockOpname::print_empty');

$routes->get('inventory_stock', 'InventoryStock::index');
$routes->post('inventory_stock', 'InventoryStock::index');

//Group Level
$routes->get('auth_groups', 'AuthGroups::index');
$routes->get('auth_groups/add', 'AuthGroups::add');
$routes->post('auth_groups/save', 'AuthGroups::save');
$routes->get('auth_groups/edit/(:segment)', 'AuthGroups::edit/$1');
$routes->post('auth_groups/update/(:segment)', 'AuthGroups::update/$1');
$routes->get('auth_groups/delete/(:num)', 'AuthGroups::delete/$1');

//History
$routes->get('history', 'History::index');
$routes->get('history/plant_group', 'History::plant_group');
$routes->post('history/log_plant_group_search', 'History::log_plant_group_search');
$routes->get('history/absent', 'History::absent');

//locker
$routes->get('locker', 'Locker::index');
$routes->get('locker/add', 'Locker::add');
$routes->post('locker/save', 'Locker::save');
$routes->get('locker/edit/(:segment)', 'Locker::edit/$1');
$routes->post('locker/update/(:segment)', 'Locker::update/$1');
$routes->get('locker/delete/(:num)', 'Locker::delete/$1');

//locker history
$routes->get('locker_history', 'LockerHistory::index');
$routes->get('locker_history/add', 'LockerHistory::add');
$routes->post('locker_history/save', 'LockerHistory::save');
$routes->get('locker_history/edit/(:segment)', 'LockerHistory::edit/$1');
$routes->post('locker_history/update/(:segment)', 'LockerHistory::update/$1');
$routes->get('locker_history/delete/(:num)', 'LockerHistory::delete/$1');

// Overtimes
$routes->group('overtimes', function ($routes) {

    $routes->get('/', 'Overtimes::index');

    $routes->match(['get', 'post'], 'search', 'Overtimes::search');

    $routes->get('add', 'Overtimes::add');
    $routes->post('store', 'Overtimes::store');

    $routes->get('edit/(:num)', 'Overtimes::edit/$1');
    $routes->post('update/(:num)', 'Overtimes::update/$1');

    $routes->get('details/(:num)', 'Overtimes::details/$1');

    $routes->post('delete-item', 'Overtimes::deleteItem');
    $routes->get('delete/(:num)', 'Overtimes::delete/$1');

    $routes->get('get-employees', 'Overtimes::getEmployeesByDivision');
    $routes->get('get-subleaders', 'Overtimes::getSubLeadersByDivision');

    $routes->post('approval', 'Overtimes::approval');
    $routes->get('notapproval/(:num)/(:num)', 'Overtimes::notapproval/$1/$2');
    $routes->get('cancelnotapproval/(:num)/(:num)', 'Overtimes::cancelnotapproval/$1/$2');
    $routes->get('send_mail/(:num)', 'Overtimes::sendMail/$1');
    $routes->get('print/(:num)', 'Overtimes::print/$1');
    $routes->get('cancel/(:num)', 'Overtimes::cancel/$1');
});
