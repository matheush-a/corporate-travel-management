<?php

namespace App\Http\Controllers;

use App\Models\TravelRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Enum\StatusEnum;

class TravelRequestController extends Controller
{
    protected $travelRequest;

    public function __construct(TravelRequest $travelRequest)
    {
        $this->travelRequest = $travelRequest;
    }

    public function index(Request $request)
    {
        $travelRequest = $this->travelRequest->newQuery();
        $filterByStatus = $request->query('status');
        $filterByDestination = $request->query('destination');

        $filterByDates = $request->query('departure_date') && $request->query('return_date');

        if ($filterByStatus) {
            $travelRequest = $travelRequest->where('status', $filterByStatus);
        }

        if ($filterByDestination) {
            $travelRequest = $travelRequest->where('destination', 'ILIKE', '%' . $filterByDestination . '%');
        }

        if ($filterByDates) {
            $travelRequest = $travelRequest->whereBetween('departure_date', [
                $request->query('departure_date'),
                $request->query('return_date')
            ]);
        }

        return response()->json($travelRequest->get(), Response::HTTP_OK);
    }

    public function show($id)
    {
        $travelRequest = $this->travelRequest->find($id);

        if (!$travelRequest) {
            return response()->json(null, Response::HTTP_NO_CONTENT);
        }
        
        return response()->json($travelRequest, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'destination' => 'required|string|max:255',
            'departure_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after_or_equal:departure_date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $authenticatedUser = $request->user();

        $travelRequest = $this->travelRequest->create([
            'user_id' => $authenticatedUser->id,
            'requester_name' => $authenticatedUser->name,
            'destination' => $request->destination,
            'departure_date' => $request->departure_date,
            'return_date' => $request->return_date,
            'status' => StatusEnum::SOLICITADO,
        ]);

        return response()->json($travelRequest, Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $travelRequest = $this->travelRequest->findOrFail($id);

        if ($travelRequest->user_id === $request->user()->id) {
            return response()->json(['error' => 'Você não pode atualizar o status de sua própria solicitação.'], Response::HTTP_UNAUTHORIZED);
        }

        if (!$this->travelRequest->updatable($travelRequest)) {
            return response()->json([
                'error' => 'O status só pode ser alterado se a data de partida for superior a 7 dias em relação à data atual.'],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:' . implode(',', [StatusEnum::APROVADO, StatusEnum::CANCELADO]),
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // TODO: implementar envio de notificação para o usuário solicitante

        $travelRequest->status = $request->status;
        $travelRequest->save();

        return response()->json($travelRequest, Response::HTTP_OK);
    }
}
