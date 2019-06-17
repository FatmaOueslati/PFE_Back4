<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @Route("/user")
 */
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
     * @Route("/new", name="user_new", methods={"POST"})
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


    /**
     * @Route("/{id}/edit", name="user_update", methods={"PUT"})
     */
    public function UpdateUser(Request $request){

        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }

        $data = array(
            'message'=>'user Not updated, send data!',
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
                        'message'=>'user updated !',
                        'errors'=>null,
                        'result'=>null
                    );
                }else{
                    $data = array(

                        'message'=>'user Not updated check data !',
                        'errors'=>null,
                        'result'=>null

                    );
                }
            }

        }

        return new JsonResponse($data);

    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function showUser($id, Request $request)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        if (empty($user)) {
            $response = array(
                'message' => 'user not found',
                'error' => null,
                'result' => null
            );

            return new JsonResponse($response);
        }

        $data = $this->get('jms_serializer')->serialize($user, 'json');

        $response = array(

            'message' => 'success',
            'errors' => null,
            'result' => json_decode($data)

        );

        return new JsonResponse($response);

    }



    /**
     * @Route("/", name="users_show", methods={"GET"})
     */
    public function listUser(Request $request)
    {
        $users=$this->getDoctrine()->getRepository(User::class)->findAll();

        if (!count($users)){
            $response=array(
                'message'=>'No users found!',
                'errors'=>null,
                'result'=>null

            );

            return new JsonResponse($response);
        }


        $data=$this->get('jms_serializer')->serialize($users,'json');

        $response=array(
            'message'=>'success',
            'errors'=>null,
            'result'=>json_decode($data)

        );


        return new JsonResponse($response);

    }


}
