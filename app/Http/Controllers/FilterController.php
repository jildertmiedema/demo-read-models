<?php
declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Widgets\AppointmentFilter\AppointmentFilter;
use App\Widgets\AppointmentFilter\Query;
use Illuminate\Http\Request;

final class FilterController extends Controller
{
    /**
     * @var AppointmentFilter
     */
    private $appointmentFilter;

    public function __construct(AppointmentFilter $filter)
    {
        $this->appointmentFilter = $filter;
    }

    public function index(Request $request)
    {
        $query = (new Query())
            ->withLimit((int) $request->input('limit', 10))
            ->withFilters(array_filter($request->input('filters', [])));

        $result = $this->appointmentFilter->query($query);

        return view('filter', compact('result', 'query'));
    }
}
