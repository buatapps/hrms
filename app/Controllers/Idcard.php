<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Idcard extends BaseController
{
    public function index()
    {
        $filters = $this->getFilters();

        $divisionOptions = in_groups('admin')
            ? $this->DivisionModel->where('id', user()->division_id)->findAll()
            : $this->DivisionModel->findAll();

        $data = [
            'title'             => 'ID Card',
            'list_data'         => $this->IdcardModel->getEmployees(null, $filters),
            'division'          => $divisionOptions,
            'plant'             => $this->PlantModel->findAll(),
            'group'             => $this->EmployeeGroupModel->findAll(),
            'division_id'       => $filters['division_id'],
            'plant_id'          => $filters['plant_id'],
            'employee_group_id' => $filters['employee_group_id'],
            'has_filter'        => $this->hasFilter($filters),
            'mirror'            => $this->isMirror()
        ];

        return view('idcard/index', $data);
    }

    public function print($id = null)
    {
        $filters   = $this->getFilters();
        $employees = $this->IdcardModel->getEmployees($id, $filters);

        return view('idcard/print', [
            'employees' => $employees,
            'mirror'    => $this->isMirror()
        ]);
    }

    public function printBack($id = null)
    {
        $employees = $this->IdcardModel->getEmployees($id, $this->getFilters());

        return view('idcard/print_back', [
            'employees' => $employees,
            'mirror'    => $this->isMirror()
        ]);
    }

    private function getFilters(): array
    {
        $divisionId = resolveDivisionFilter($this->request->getVar('division_id'));
        $plantId    = $this->request->getVar('plant_id');
        $groupId    = $this->request->getVar('employee_group_id');

        return [
            'division_id'       => empty($divisionId) ? null : (int) $divisionId,
            'plant_id'          => empty($plantId) ? null : (int) $plantId,
            'employee_group_id' => empty($groupId) ? null : (int) $groupId
        ];
    }

    private function hasFilter(array $filters): bool
    {
        return $filters['division_id'] !== null
            || $filters['plant_id'] !== null
            || $filters['employee_group_id'] !== null;
    }

    private function isMirror(): bool
    {
        return (bool) $this->request->getVar('mirror');
    }
}
