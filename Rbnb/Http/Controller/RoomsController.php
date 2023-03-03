<?php


namespace Rbnb\Http\Controller;

use Rbnb\Database\Model\Reservation;
use Rbnb\Database\Model\Rooms;
use Rbnb\Database\Repository\RepositoryManager;
use Rbnb\Database\Repository\EquipementsRepository;
use Rbnb\Database\Repository\ReservationRepository;
use Rbnb\Rbnb;
use Rbnb\System\Http\Controller;
use Rbnb\System\Session\Session;

use Zend\Diactoros\Response\RedirectResponse;
use Zend\Diactoros\ServerRequest;
class RoomsController extends Controller
{
    #region Affichage

    public function index(): void
    {

        $rooms_repo = RepositoryManager::manager()->roomsRepository();

        echo $this->twig->render( 'renter/voir-location.twig', [
            'title' => 'Locations',
            'rooms' => $rooms_repo->findByOwnerId(Session::get( Session::USER )->id)
        ]);
    }

    public function show(): void
    {
        $resa_repo = RepositoryManager::manager()->reservationRepository();

        echo $this->twig->render( 'renter/voir-reservation.twig', [
            'title' => 'Mes réservations',
            'rooms' => $resa_repo->findByReservationId(Session::get( Session::USER )->id)
        ]);
    }

    public function add(): void
    {
        $typeOfRoom_repo = RepositoryManager::manager()->typeOfRoomRepository();
        $equipements_repo = RepositoryManager::manager()->equipementsRepository();

        echo $this->twig->render( 'renter/ajout-location.twig', [
            'title' => 'Ajouter une annonce',
            'form_status' => Session::get( Session::FORM_STATUS ),
            'equipements' => $equipements_repo->findAll(),
            'room_types' => $typeOfRoom_repo->findAll(),
            'rooms_owner' => Session::get( Session::USER )->id,
        ] );
    }

    #endregion Affichage

    #region Traitement


    public function insert( ServerRequest $request): RedirectResponse
    {

            $router = Rbnb::app()->getRouter();
            $data = $request->getParsedBody();

            $input['city'] = $data[ 'city' ] ?? -1;
            $input['country'] = $data[ 'country' ] ?? -1;
            $input['price'] = $data[ 'price' ] ?? -1;
            $input['type_id'] = $data[ 'type_id' ] ?? -1;
            $input['size'] = $data[ 'size' ] ?? -1;
            $input['description'] = $data[ 'description' ] ?? -1;
            $input['beds'] = $data[ 'beds' ] ?? -1;
            $input['rooms_owner'] = $data[ 'rooms_owner' ] ?? -1;
            $input['equipements'] = $data[ 'equipements' ] ?? -1;

            if( ! empty( $input ) && ! array_search( null, $input ) && is_array($input['equipements'])) {
                $repo = RepositoryManager::manager()->RoomsRepository();
                $repo_equipements = RepositoryManager::manager()->EquipementsRepository();
               
                $success = $repo->insert( new Rooms( $input ) );
                $equipements_success = $repo_equipements->bind( $success, $input['equipements']);


                if( ! $success ) {
                    // TODO: Gérer une erreur d'insertion
                }else{
                    return new RedirectResponse( $router->url( 'locations' )  );
                }
            }
            else {
                // TODO: Gérer une erreur de formulaire
            }

            return new RedirectResponse( $router->url('locations') );

    }

        #endregion Traitement
    };

