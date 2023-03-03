<?php

namespace Rbnb\Http\Controller;


use Rbnb\Rbnb;
use Rbnb\Database\Model\Roles;
use Rbnb\System\Http\Auth;
use Rbnb\System\Http\Controller;
use Rbnb\System\FormStatus;
use Rbnb\System\Session\Session;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Diactoros\ServerRequest;

class AuthController extends Controller
{
    public static function getRoleDefaultRouteName(int $role_id): string {
        $output = '';
        switch( $role_id ) {
            case Roles::RENTER:
                $output = 'locations';
                break;

            case Roles::USER:
                $output = 'annonces';
                break;

            default:
                Session::set( Session::USER, null );
                $output = 'home';

        }
        return $output;
    }

    public function index(): void
    {
        echo $this->twig->render( 'visitor/login.twig', [
            'title' => 'Connexion',
            'form_status' => Session::get( Session::FORM_STATUS )
        ]);
    }

    public function auth( ServerRequest $request ): RedirectResponse
    {
        $post_data = $request->getParsedBody();

        // noms des inputs attendus
        $name_email = 'email';
        $name_password = 'password';

        $input_email = $post_data[ $name_email ] ?? null;
        $input_password = $post_data[ $name_password ] ?? null;

        $router = Rbnb::app()->getRouter();

        if( is_null( $input_email ) || is_null( $input_password ) )
            return new RedirectResponse( $router->url( 'home' ) );

        // SHOULDDO: Validation de la saisie (format de l'email, etc.)

        $check_result = Rbnb::app()->getAuth()->checkLogin( $input_email, $input_password );

        $redirect_route = 'login';

        if( $check_result > 0 ) {
            Session::set( Session::FORM_STATUS, null );

            $redirect_route = self::getRoleDefaultRouteName($check_result);

            // var_dump('die here '.$redirect_route);die();

            return new RedirectResponse( $router->url( $redirect_route ) );
        }

        // Gestion des erreurs du formulaire
        $form_status = new FormStatus();

        // Erreurs
        switch( $check_result ) {
            case Auth::ERROR_EMAIL_MISSING:
                $form_status->addError( $name_email, 'Veuillez renseigner une adresse email.' );
                break;

            case Auth::ERROR_EMAIL_BAD:
                $form_status->addError( $name_email, 'Adresse email inconnue.' );
                break;

            case Auth::ERROR_PASSWORD_MISSING:
                $form_status->addError( $name_password, 'Veuillez renseigner un mot de passe.' );
                break;

            case Auth::ERROR_PASSWORD_BAD:
                $form_status->addError( $name_password, 'Mot de passe incorrect.' );
                break;

            default:
                // SHOULDDO: Log de l'erreur car anomalie
                break;
        }

        // Valeurs
        if( is_null( $form_status->getError( $name_email ) ) )
            $form_status->addValue( $name_email, $input_email );

        if( is_null( $form_status->getError( $name_password ) ) )
            $form_status->addValue( $name_password, $input_password );

        Session::set( Session::FORM_STATUS, $form_status );



        return new RedirectResponse( $router->url( $redirect_route ) );
    }

    public function logout()
    {
        Session::unset();

        $router = Rbnb::app()->getRouter();

        return new RedirectResponse( $router->url( 'home' ) );
    }
}