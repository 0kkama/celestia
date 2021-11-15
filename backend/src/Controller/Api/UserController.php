<?php


namespace App\Controller\Api;


use App\Security\UserProvider;
use App\Service\User\Context\RegisterUserContext;
use App\Service\User\Context\UpdateUserDataContext;
use App\Service\User\Exception\UserAlreadyExistsException;
use App\Service\User\UserAccessTokenService;
use App\Service\User\UserService;
use App\Validator\Constraints\Phone;
use Creonit\RestBundle\Annotation\Parameter\RequestParameter;
use Creonit\RestBundle\Handler\RestHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @Route("/users")
 */
class UserController extends AbstractController
{
    /**
     * Зарегистрировать пользователя
     *
     * @RequestParameter("email", type="string", description="Email")
     * @RequestParameter("password", type="string", description="Пароль")
     *
     * @Route("", methods={"POST"})
     */
    public function register(Request $request, RestHandler $handler, UserService $userService, UserAccessTokenService $accessTokenService)
    {
        $request->request->set('type', $request->request->getInt('type'));

        $handler->validate([
            'request' => [
                'email' => [new NotBlank(), new Email()],
                'password' => [new NotBlank(), new Length(['min' => 6])],
            ]
        ]);

        $registerUserContext = (new RegisterUserContext())
            ->setEmail($request->request->get('email'))
            ->setPassword($request->request->get('password'));

        try {
            $user = $userService->registerUser($registerUserContext);
            $token = $accessTokenService->createAccessToken($user);

        } catch (UserAlreadyExistsException $e) {
            $handler->error->set('request/email', 'Пользователь уже существует')->send();
        }

        $handler->data->set([
            'user' => $user,
            'token' => $token,
        ]);

        return $handler->response();
    }

    /**
     * Получить токен доступа
     *
     * @RequestParameter("email", type="string", description="Email")
     * @RequestParameter("password", type="string", description="Пароль")
     *
     * @Route("/tokens", methods={"POST"})
     */
    public function createToken(Request $request, RestHandler $handler, UserProvider $userProvider, UserService $userService, UserAccessTokenService $accessTokenService)
    {
        $handler->validate([
            'request' => [
                'email' => [new NotBlank(), new Email()],
                'password' => [new NotBlank(), new Length(['min' => 6])],
            ]
        ]);

        try {
            $user = $userProvider->loadUserByUsername($request->request->get('email'));
            if (!$userService->checkPassword($user, $request->request->get('password'))) {
                throw new AuthenticationException();
            }

            $token = $accessTokenService->createAccessToken($user);

        } catch (AuthenticationException $exception) {
            $handler->error->set('request/email', 'Неправильный логин или пароль')->send();
        }

        $handler->data->set([
            'user' => $user,
            'token' => $token,
        ]);

        return $handler->response();
    }

    /**
     * Получить личные данные
     *
     * @Route("/self", methods={"GET"})
     */
    public function getData(RestHandler $handler)
    {
        $handler->checkAuthorization();
        $handler->data->set($this->getUser());

        return $handler->response();
    }

    /**
     * Изменить персональные данные
     *
     * @RequestParameter("firstName", type="string", description="Имя")
     * @RequestParameter("lastName", type="string", description="Фамилия")
     * @RequestParameter("phone", type="string", description="Телефон")
     *
     * @Route("/self", methods={"POST"})
     */
    public function updateUserData(RestHandler $handler, Request $request, UserService $userService)
    {
        $handler->checkAuthorization();

        $handler->validate([
            'request' => [
                'firstName' => [new NotBlank()],
                'lastName' => [new NotBlank()],
                'phone' => [new Phone()]
            ]
        ]);

        $updateUserDataContext = (new UpdateUserDataContext())
            ->setFirstName($request->request->get('firstName'))
            ->setLastName($request->request->get('lastName'))
            ->setPhone($request->request->get('phone'));

        $userService->updateUserData($this->getUser(), $updateUserDataContext);

        $handler->data->set($this->getUser());

        return $handler->response();
    }


    /**
     * Изменить пароль
     *
     * @RequestParameter("currentPassword", type="string", description="Текущий пароль")
     * @RequestParameter("password", type="string", description="Пароль")
     * @RequestParameter("confirmPassword", type="string", description="Повтор пароля")
     *
     * @Route("/self/password", methods={"POST"})
     */
    public function changePassword(RestHandler $handler, Request $request, UserService $userService)
    {
        $handler->checkAuthorization();

        $handler->validate([
            'request' => [
                'currentPassword' => [new NotBlank(), new Length(['min' => 6])],
                'password' => [new NotBlank(), new Length(['min' => 6])],
                'confirmPassword' => [new NotBlank(), new EqualTo([
                    'value' => $request->request->get('password'),
                    'message' => 'Пароли не совпадают',
                ])],
            ]
        ]);

        $user = $this->getUser();

        if (!$userService->checkPassword($user, $request->request->get('currentPassword'))) {
            $handler->error->set('request/currentPassword', 'Неправильный пароль')->send();
        }

        $userService->changePassword($user, $request->request->get('password'));
        $user->save();

        return $handler->response();
    }
}
