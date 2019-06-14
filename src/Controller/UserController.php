<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserController extends AbstractController
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * UserController constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }


    /**
     * @Route("/register")
     * @Method("POST")
     * @param Request $request
     * @return JsonResponse
     */
    public function newUser(Request $request){

        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }

        $data = array(
            'message'=>'user Not created, send data!',
            'result'=>null
        );


        if($parametersAsArray !=null){


            $email = (isset($parametersAsArray['email'])) ? $parametersAsArray['email'] : null;
            $name = (isset($parametersAsArray['name'])) ? $parametersAsArray['name'] : null;
            $password = (isset($parametersAsArray['password'])) ? $parametersAsArray['password'] : null;
            $username = (isset($parametersAsArray['username'])) ? $parametersAsArray['username'] : null;

            if($email != null  && $password != null && $name != null && $username != null){

                $user = new User();

                $user->setUsername($username);
                $user->setEmail($email);
                $user->setName($name);
                $user->setPassword($this->passwordEncoder->encodePassword($user, $password));

                $em = $this->getDoctrine()->getManager();
                $isset_user = $em->getRepository(User::class)->findBy(array(
                    "username" => $username
                ));

                if(count($isset_user)==0){
                    $em->persist($user);
                    $em->flush();

                    $data = array(
                        'message'=>'user created !',
                        'errors'=>null,
                        'result'=>null
                    );
                }else{
                    $data = array(

                        'message'=>'user Not created check email !',
                        'errors'=>null,
                        'result'=>null

                    );
                }
            }

        }

        return new JsonResponse($data);

    }
}
