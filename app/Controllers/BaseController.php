<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * @property \App\Models\AbsentModel $AbsentModel
 * @property \App\Models\AbsentTypeModel $AbsentTypeModel
 * @property \App\Models\AttendanceMachineModel $AttendanceMachineModel
 * @property \App\Models\AttendanceModel $AttendanceModel
 * @property \App\Models\AuthGroupsModel $AuthGroupsModel
 * @property \App\Models\BankModel $BankModel
 * @property \App\Models\BloodTypeModel $BloodTypeModel
 * @property \App\Models\CompanyModel $CompanyModel
 * @property \App\Models\ContractModel $ContractModel
 * @property \App\Models\ContractStatusesModel $ContractStatusesModel
 * @property \App\Models\ContractTypesModel $ContractTypesModel
 * @property \App\Models\CountFoodModel $CountFoodModel
 * @property \App\Models\DashboardModel $DashboardModel
 * @property \App\Models\DependentModel $DependentModel
 * @property \App\Models\DigimanVideoModel $DigimanVideoModel
 * @property \App\Models\DivisionModel $DivisionModel
 * @property \App\Models\EducationModel $EducationModel
 * @property \App\Models\EmployeeGroupModel $EmployeeGroupModel
 * @property \App\Models\EmployeeLateModel $EmployeeLateModel
 * @property \App\Models\EmployeeModel $EmployeeModel
 * @property \App\Models\EmployeeScheduleModel $EmployeeScheduleModel
 * @property \App\Models\EmployeeStatusModel $EmployeeStatusModel
 * @property \App\Models\EmployeeUploadsModel $EmployeeUploadsModel
 * @property \App\Models\GenderModel $GenderModel
 * @property \App\Models\GuestModel $GuestModel
 * @property \App\Models\HardwareBrandModel $HardwareBrandModel
 * @property \App\Models\HardwareCategoryModel $HardwareCategoryModel
 * @property \App\Models\HardwareModel $HardwareModel
 * @property \App\Models\IdcardModel $IdcardModel
 * @property \App\Models\InventoryCategoryModel $InventoryCategoryModel
 * @property \App\Models\InventoryItemsModel $InventoryItemsModel
 * @property \App\Models\InventorySnapshotModel $InventorySnapshotModel
 * @property \App\Models\InventoryStockOpnameHeaderModel $InventoryStockOpnameHeaderModel
 * @property \App\Models\InventoryStockOpnameModel $InventoryStockOpnameModel
 * @property \App\Models\InventoryTransactionOutTypeModel $InventoryTransactionOutTypeModel
 * @property \App\Models\InventoryTransactionsInModel $InventoryTransactionsInModel
 * @property \App\Models\InventoryTransactionsOutModel $InventoryTransactionsOutModel
 * @property \App\Models\JamIstirahatModel $JamIstirahatModel
 * @property \App\Models\LockerHistoryModel $LockerHistoryModel
 * @property \App\Models\LockerModel $LockerModel
 * @property \App\Models\LogHistoryAbsentModel $LogHistoryAbsentModel
 * @property \App\Models\LogHistoryModel $LogHistoryModel
 * @property \App\Models\MarriageStatusModel $MarriageStatusModel
 * @property \App\Models\NetworkModel $NetworkModel
 * @property \App\Models\OvertimeApprovalModel $OvertimeApprovalModel
 * @property \App\Models\OvertimeApprovalsModel $OvertimeApprovalsModel
 * @property \App\Models\OvertimeCategoriesModel $OvertimeCategoriesModel
 * @property \App\Models\OvertimeDetailModel $OvertimeDetailModel
 * @property \App\Models\OvertimeHeaderModel $OvertimeHeaderModel
 * @property \App\Models\OvertimeItemsModel $OvertimeItemsModel
 * @property \App\Models\OvertimeModel $OvertimeModel
 * @property \App\Models\OvertimesModel $OvertimesModel
 * @property \App\Models\PlantModel $PlantModel
 * @property \App\Models\PositionModel $PositionModel
 * @property \App\Models\ProductSynchronizationModel $ProductSynchronizationModel
 * @property \App\Models\ReligionModel $ReligionModel
 * @property \App\Models\ResignModel $ResignModel
 * @property \App\Models\SectionModel $SectionModel
 * @property \App\Models\SertifikatModel $SertifikatModel
 * @property \App\Models\ShiftModel $ShiftModel
 * @property \App\Models\ShoesSizeModel $ShoesSizeModel
 * @property \App\Models\SimModel $SimModel
 * @property \App\Models\SoftwareModel $SoftwareModel
 * @property \App\Models\StnkModel $StnkModel
 * @property \App\Models\TaxStatusModel $TaxStatusModel
 * @property \App\Models\TipeSertifikatModel $TipeSertifikatModel
 * @property \App\Models\TicketCategoryModel $TicketCategoryModel
 * @property \App\Models\TicketModel $TicketModel
 * @property \App\Models\TicketStatusModel $TicketStatusModel
 * @property \App\Models\UniformSizeModel $UniformSizeModel
 * @property \App\Models\UserModel $UserModel
 * @property \App\Models\WelcomeBoardModel $WelcomeBoardModel
 * @property \App\Models\WorkingDaysModel $WorkingDaysModel
 * @property \App\Models\WorkingHoursModel $WorkingHoursModel
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = ['auth', 'form', 'url'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    private const MODELS = [
        'DashboardModel',
        'GuestModel',
        'CompanyModel',
        'UserModel',
        'SectionModel',
        'PositionModel',
        'EmployeeModel',
        'EducationModel',
        'EmployeeStatusModel',
        'GenderModel',
        'ReligionModel',
        'MarriageStatusModel',
        'BankModel',
        'UniformSizeModel',
        'ShoesSizeModel',
        'WelcomeBoardModel',
        'DivisionModel',
        'PlantModel',
        'EmployeeGroupModel',
        'TaxStatusModel',
        'DependentModel',
        'BloodTypeModel',
        'ProductSynchronizationModel',
        'AttendanceMachineModel',
        'AttendanceModel',
        'ShiftModel',
        'WorkingHoursModel',
        'WorkingDaysModel',
        'EmployeeScheduleModel',
        'EmployeeLateModel',
        'CountFoodModel',
        'AbsentTypeModel',
        'StnkModel',
        'SimModel',
        'ContractModel',
        'AbsentModel',
        'OvertimeModel',
        'TicketModel',
        'TicketStatusModel',
        'TicketCategoryModel',
        'HardwareModel',
        'HardwareCategoryModel',
        'HardwareBrandModel',
        'SoftwareModel',
        'NetworkModel',
        'ResignModel',
        'OvertimeHeaderModel',
        'OvertimeDetailModel',
        'InventoryCategoryModel',
        'InventoryItemsModel',
        'InventoryTransactionsInModel',
        'InventorySnapshotModel',
        'InventoryTransactionOutTypeModel',
        'InventoryTransactionsOutModel',
        'InventoryStockOpnameHeaderModel',
        'InventoryStockOpnameModel',
        'AuthGroupsModel',
        'ContractTypesModel',
        'ContractStatusesModel',
        'EmployeeUploadsModel',
        'LogHistoryModel',
        'LogHistoryAbsentModel',
        'LockerModel',
        'LockerHistoryModel',
        'OvertimesModel',
        'OvertimeItemsModel',
        'OvertimeCategoriesModel',
        'OvertimeApprovalsModel',
        'OvertimeApprovalModel',
        'SertifikatModel',
        'TipeSertifikatModel',
        'JamIstirahatModel',
        'DigimanVideoModel',
        'IdcardModel',
    ];

    private array $modelInstances = [];

    public function __get(string $name)
    {
        if (isset($this->modelInstances[$name])) {
            return $this->modelInstances[$name];
        }

        if (! in_array($name, self::MODELS, true)) {
            throw new \RuntimeException('Unknown model property: ' . $name);
        }

        $class = '\\App\\Models\\' . $name;

        if (! class_exists($class)) {
            throw new \RuntimeException('Model class not found: ' . $class);
        }

        return $this->modelInstances[$name] = new $class();
    }

    public function __isset(string $name): bool
    {
        return isset($this->modelInstances[$name]);
    }

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        session();
    }
}
