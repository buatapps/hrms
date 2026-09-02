<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

//Model
use App\Models\DashboardModel;
use App\Models\GuestModel;
use App\Models\UserModel;
use App\Models\CompanyModel;
use App\Models\SectionModel;
use App\Models\PositionModel;
use App\Models\EducationModel;
use App\Models\EmployeeStatusModel;
use App\Models\GenderModel;
use App\Models\ReligionModel;
use App\Models\MarriageStatusModel;
use App\Models\EmployeeModel;
use App\Models\BankModel;
use App\Models\UniformSizeModel;
use App\Models\ShoesSizeModel;
use App\Models\WelcomeBoardModel;
use App\Models\DivisionModel;
use App\Models\PlantModel;
use App\Models\EmployeeGroupModel;
use App\Models\TaxStatusModel;
use App\Models\DependentModel;
use App\Models\BloodTypeModel;
use App\Models\ProductSynchronizationModel;
use App\Models\AttendanceMachineModel;
use App\Models\AttendanceModel;
use App\Models\ShiftModel;
use App\Models\WorkingHoursModel;
use App\Models\WorkingDaysModel;
use App\Models\EmployeeScheduleModel;
use App\Models\EmployeeLateModel;
use App\Models\CountFoodModel;
use App\Models\AbsentTypeModel;
use App\Models\StnkModel;
use App\Models\SimModel;
use App\Models\ContractModel;
use App\Models\AbsentModel;
use App\Models\OvertimeModel;
use App\Models\TicketModel;
use App\Models\TicketStatusModel;
use App\Models\TicketCategoryModel;
use App\Models\HardwareModel;
use App\Models\HardwareCategoryModel;
use App\Models\HardwareBrandModel;
use App\Models\SoftwareModel;
use App\Models\NetworkModel;
use App\Models\ResignModel;
use App\Models\OvertimeHeaderModel;
use App\Models\OvertimeDetailModel;
use App\Models\InventoryCategoryModel;
use App\Models\InventoryItemsModel;
use App\Models\InventoryTransactionsInModel;
use App\Models\InventorySnapshotModel;
use App\Models\InventoryTransactionOutTypeModel;
use App\Models\InventoryTransactionsOutModel;
use App\Models\InventoryStockOpnameHeaderModel;
use App\Models\InventoryStockOpnameModel;
use App\Models\AuthGroupsModel;
use App\Models\ContractTypesModel;
use App\Models\ContractStatusesModel;
use App\Models\EmployeeUploadsModel;
use App\Models\LogHistoryModel;
use App\Models\LogHistoryAbsentModel;
use App\Models\LockerModel;
use App\Models\LockerHistoryModel;
use App\Models\OvertimesModel;
use App\Models\OvertimeItemsModel;
use App\Models\OvertimeCategoriesModel;
use App\Models\OvertimeApprovalsModel;
use App\Models\OvertimeApprovalModel;
use App\Models\SertifikatModel;
use App\Models\TipeSertifikatModel;
use App\Models\JamIstirahatModel;
use App\Models\DigimanVideoModel;


/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
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

    /**
     * @return void
     */
    protected $DashboardModel, $GuestModel, $CompanyModel, $UserModel, $SectionModel, $PositionModel, $EmployeeModel, $EducationModel, $EmployeeStatusModel, $GenderModel, $ReligionModel, $MarriageStatusModel, $BankModel, $UniformSizeModel, $ShoesSizeModel, $WelcomeBoardModel, $DivisionModel, $PlantModel, $EmployeeGroupModel, $TaxStatusModel, $DependentModel, $BloodTypeModel, $ProductSynchronizationModel, $AttendanceMachineModel, $AttendanceModel, $ShiftModel, $WorkingHoursModel, $WorkingDaysModel, $EmployeeScheduleModel, $EmployeeLateModel, $CountFoodModel, $AbsentTypeModel, $StnkModel, $SimModel, $ContractModel, $AbsentModel, $OvertimeModel, $TicketModel, $TicketStatusModel, $TicketCategoryModel, $HardwareModel, $HardwareCategoryModel, $HardwareBrandModel, $SoftwareModel, $NetworkModel, $ResignModel, $OvertimeHeaderModel, $OvertimeDetailModel, $InventoryCategoryModel, $InventoryItemsModel, $InventoryTransactionsInModel, $InventorySnapshotModel, $InventoryTransactionOutTypeModel, $InventoryTransactionsOutModel, $InventoryStockOpnameHeaderModel, $InventoryStockOpnameModel, $AuthGroupsModel, $ContractTypesModel, $ContractStatusesModel, $EmployeeUploadsModel, $LogHistoryModel, $LogHistoryAbsentModel, $LockerModel, $LockerHistoryModel, $OvertimesModel, $OvertimeItemsModel, $OvertimeCategoriesModel, $OvertimeApprovalsModel, $OvertimeApprovalModel, $SertifikatModel, $TipeSertifikatModel, $JamIstirahatModel, $DigimanVideoModel;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = service('session');
        session();
        $this->DashboardModel = new DashboardModel();
        $this->GuestModel = new GuestModel();
        $this->UserModel = new UserModel();
        $this->CompanyModel = new CompanyModel();
        $this->SectionModel = new SectionModel();
        $this->PositionModel = new PositionModel();
        $this->EducationModel = new EducationModel();
        $this->EmployeeStatusModel = new EmployeeStatusModel();
        $this->GenderModel = new GenderModel();
        $this->ReligionModel = new ReligionModel();
        $this->MarriageStatusModel = new MarriageStatusModel();
        $this->EmployeeModel = new EmployeeModel();
        $this->BankModel = new BankModel();
        $this->UniformSizeModel = new UniformSizeModel();
        $this->ShoesSizeModel = new ShoesSizeModel();
        $this->WelcomeBoardModel = new WelcomeBoardModel();
        $this->DivisionModel = new DivisionModel();
        $this->PlantModel = new PlantModel();
        $this->EmployeeGroupModel = new EmployeeGroupModel();
        $this->TaxStatusModel = new TaxStatusModel();
        $this->DependentModel = new DependentModel();
        $this->BloodTypeModel = new BloodTypeModel();
        $this->ProductSynchronizationModel = new ProductSynchronizationModel();
        $this->AttendanceMachineModel = new AttendanceMachineModel();
        $this->AttendanceModel = new AttendanceModel();
        $this->ShiftModel = new ShiftModel();
        $this->WorkingHoursModel = new WorkingHoursModel();
        $this->WorkingDaysModel = new WorkingDaysModel();
        $this->EmployeeScheduleModel = new EmployeeScheduleModel();
        $this->EmployeeLateModel = new EmployeeLateModel();
        $this->CountFoodModel = new CountFoodModel();
        $this->AbsentTypeModel = new AbsentTypeModel();
        $this->StnkModel = new StnkModel();
        $this->SimModel = new SimModel();
        $this->ContractModel = new ContractModel();
        $this->AbsentModel = new AbsentModel();
        $this->OvertimeModel = new OvertimeModel();
        $this->TicketModel = new TicketModel();
        $this->TicketStatusModel = new TicketStatusModel();
        $this->TicketCategoryModel = new TicketCategoryModel();
        $this->HardwareModel = new HardwareModel();
        $this->HardwareCategoryModel = new HardwareCategoryModel();
        $this->HardwareBrandModel = new HardwareBrandModel();
        $this->SoftwareModel = new SoftwareModel();
        $this->NetworkModel = new NetworkModel();
        $this->ResignModel = new ResignModel();
        $this->OvertimeHeaderModel = new OvertimeHeaderModel();
        $this->OvertimeDetailModel = new OvertimeDetailModel();
        $this->InventoryCategoryModel = new InventoryCategoryModel();
        $this->InventoryItemsModel = new InventoryItemsModel();
        $this->InventoryTransactionsInModel = new InventoryTransactionsInModel();
        $this->InventorySnapshotModel = new InventorySnapshotModel();
        $this->InventoryTransactionOutTypeModel = new InventoryTransactionOutTypeModel();
        $this->InventoryTransactionsOutModel = new InventoryTransactionsOutModel();
        $this->InventoryStockOpnameHeaderModel = new InventoryStockOpnameHeaderModel();
        $this->InventoryStockOpnameModel = new InventoryStockOpnameModel();
        $this->AuthGroupsModel = new AuthGroupsModel();
        $this->ContractTypesModel = new ContractTypesModel();
        $this->ContractStatusesModel = new ContractStatusesModel();
        $this->EmployeeUploadsModel = new EmployeeUploadsModel();
        $this->LogHistoryModel = new LogHistoryModel();
        $this->LogHistoryAbsentModel = new LogHistoryAbsentModel();
        $this->LockerModel = new LockerModel();
        $this->LockerHistoryModel = new LockerHistoryModel();
        $this->OvertimesModel = new OvertimesModel();
        $this->OvertimeItemsModel = new OvertimeItemsModel();
        $this->OvertimeCategoriesModel = new OvertimeCategoriesModel();
        $this->OvertimeApprovalsModel = new OvertimeApprovalsModel();
        $this->OvertimeApprovalModel = new OvertimeApprovalModel();
        $this->SertifikatModel = new SertifikatModel();
        $this->TipeSertifikatModel = new TipeSertifikatModel();
        $this->JamIstirahatModel = new JamIstirahatModel();
        $this->DigimanVideoModel = new DigimanVideoModel();
    }
}
