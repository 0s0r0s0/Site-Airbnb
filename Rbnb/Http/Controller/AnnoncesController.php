<?php


namespace Rbnb\Http\Controller;


use Rbnb\Database\Model\Reservation;
use Rbnb\Database\Repository\RepositoryManager;
use Rbnb\Rbnb;
use Rbnb\System\Http\Controller;

use Rbnb\System\Session\Session;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Diactoros\ServerRequest;

class AnnoncesController extends Controller
{
    public function index(): void
    {

        $rooms_repo = RepositoryManager::manager()->roomsRepository();

        echo $this->twig->render( 'user/annonces.twig', [
            'title' => 'Locations',
            'rooms' => $rooms_repo->findAll()
        ]);
    }

    public function show(int $id): void
    {

        $rooms_repo = RepositoryManager::manager()->roomsRepository();
        $room_type_repo = RepositoryManager::manager()->typeOfRoomRepository();
        $equipements_repo = RepositoryManager::manager()->equipementsRepository();

        $rooms_data = $rooms_repo->findById($id);
        $rooms_data->room_type = $room_type_repo->findLabelById($rooms_data->type_id);
        $rooms_data->equipements = $equipements_repo->findByRoomsId($rooms_data->id);

        echo $this->twig->render ( 'user/details.twig', [
            'title' => 'Location',
            'rooms' => $rooms_data,
            'user_id' => Session::get( Session::USER )->id
        ]);

    }

    public function book( ServerRequest $request )
    {
        $router = Rbnb::app()->getRouter();
        $data = $request->getParsedBody();

        $input['start_rent'] = $data[ 'start_rent' ] ?? -1;
        $input['end_rent'] = $data[ 'end_rent' ] ?? -1;
        $input['user_id'] = $data[ 'user_id' ] ?? -1;
        $input['room_id'] = $data[ 'room_id' ] ?? -1;

        if( ! empty( $input ) && ! array_search( null, $input )) {
            $repo = RepositoryManager::manager()->ReservationRepository();
            $success = $repo->insert( new Reservation( $input ) );

            if( ! $success ) {
                // TODO: Gérer une erreur d'insertion
            }else{
                return new RedirectResponse( $router->url( 'annonces' )  );
            }
        }
        else {
            // TODO: Gérer une erreur de formulaire
        }

        return new RedirectResponse( $router->url('annonces') );
    }

    public function booked(): void
    {
        $resa_repo = RepositoryManager::manager()->reservationRepository();

        echo $this->twig->render( 'user/reservation.twig', [
            'title' => 'Mes réservations',
            'rooms' => $resa_repo->findByUserId(Session::get( Session::USER )->id)

        ]);
    }

}