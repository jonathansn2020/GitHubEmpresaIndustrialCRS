<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanning extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name_activity'     => 'required|max:100|string',
            'priority'          => 'required|max:20|string',
            'start_date'        => 'required|date',
            'expected_date'     => 'required|date',
            'stage_id'          => 'required',
            'operator_id'       => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name_activity'     => 'nombre de actividad',
            'priority'          => 'prioridad de trabajo',
            'start_date'        => 'fecha inicio planificado',
            'expected_date'     => 'fecha fin planificado',
            'stage_id'          => 'etapa de fabricación',
            'operator_id'       => 'operario',
        ];
    }
}
