namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationSuccessListener
{
    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if ($user instanceof UserInterface) {
            $data['user'] = [
                'id' => method_exists($user, 'getId') ? $user->getId() : null,
                'username' => $user->getUserIdentifier(),
                // Ajoutez d'autres champs si besoin
            ];
            $event->setData($data);
        }
    }
}
