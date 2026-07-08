<?php

if (! function_exists('resolveDivisionFilter')) {
    function resolveDivisionFilter($requestDivisionId = null)
    {
        // Superadmin → bebas lihat semua / pilih dari filter
        if (in_groups('superadmin')) {
            return $requestDivisionId ?: null;
        }

        // Admin → dikunci ke divisinya sendiri
        if (in_groups('admin')) {
            return user()->division_id;
        }

        // default (kalau ada role lain nanti)
        return null;
    }
}