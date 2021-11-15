<?php


namespace App\Service\User;


use App\Helper\PhoneHelper;
use App\Model\User;
use App\Service\User\Context\RegisterUserContext;
use App\Service\User\Context\UpdateUserDataContext;
use App\Service\User\Exception\UserAlreadyExistsException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserService
{
    protected UserRepository $userRepository;
    protected UserPasswordEncoderInterface $passwordEncoder;
    protected PhoneHelper $phoneHelper;

    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder, PhoneHelper $phoneHelper)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->phoneHelper = $phoneHelper;
    }

    /**
     * @param RegisterUserContext $registerUserContext
     * @return User
     * @throws UserAlreadyExistsException
     */
    public function registerUser(RegisterUserContext $registerUserContext)
    {
        if ($this->userRepository->getUserByEmail($registerUserContext->getEmail())) {
            throw (new UserAlreadyExistsException())->setUsername($registerUserContext->getEmail());
        }

        $user = $this->createUserByEmail($registerUserContext->getEmail(), $registerUserContext->getPassword());
        $user->save();

        return $user;
    }

    public function createUserByEmail(string $email, string $password): User
    {
        $user = new User();
        $user->setEmail($email);
        $this->changePassword($user, $password);

        return $user;
    }

    public function changePassword(User $user, string $password): void
    {
        $user->setSalt(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));
        $password = $this->passwordEncoder->encodePassword($user, $password);
        $user->setPassword($password);
    }

    public function checkPassword(UserInterface $user, string $password): bool
    {
        return $this->passwordEncoder->isPasswordValid($user, $password);
    }

    public function updateUserData(User $user, UpdateUserDataContext $updateUserDataContext)
    {
        $user->setFirstName($updateUserDataContext->getFirstName());
        $user->setLastName($updateUserDataContext->getLastName());
        $user->setPhone(
            $this->phoneHelper->normalizePhone($updateUserDataContext->getPhone())
        );

        $user->save();
    }
}
