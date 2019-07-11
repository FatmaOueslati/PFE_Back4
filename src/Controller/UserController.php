<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    /* *
     * @Route("/getID/{username}", methods={"get"})
     *
    public function getID($username){


        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findBy(array(
            "username" => $username
        ));

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $data = $serializer -> serialize($user,'json');


        $response = array(

            'result' => json_decode($data)

        );
        return new JsonResponse($response);
    }
*/

    /**
     * @Route("/register", methods={"POST"})
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
     * @Route("/updateProfile/{id}" , methods={"PUT"})
     */

    public function UpdateUser($id, Request $request)
    {
        $data=[];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);

            if ($parametersAsArray != null) {

                $user = $this->getDoctrine()->getRepository(User::class)->find($id);

                if (empty($user)) {
                    $response = array(
                        'message' => 'user not found',
                        'error' => null,
                        'result' => null
                    );

                    return new JsonResponse($response);
                }

                $em = $this->getDoctrine()->getManager();

                $name = (isset($parametersAsArray['name'])) ? $parametersAsArray['name'] : null;
                $password = (isset($parametersAsArray['password'])) ? $parametersAsArray['password'] : null;
                $email = (isset($parametersAsArray['email'])) ? $parametersAsArray['email'] : null;
                $username = (isset($parametersAsArray['username'])) ? $parametersAsArray['username'] : null;

                if ($email != null && $password != null && $name != null && $username != null) {

                    $user->setName($parametersAsArray['name']);
                    $user->setUsername($username);
                    $user->setEmail($parametersAsArray['email']);
                    $user->setPassword($this->passwordEncoder->encodePassword($user, $password));


                    $em->persist($user);
                    $em->flush();

                    $data = array(
                        "data" => "user updated",
                        'errors' => null,
                        'result' => null
                    );

                }

            }else {
                $data = array(
                    "data" => "parameters failed",
                    'result' => null

                );


            }

        }

        return new JsonResponse($data);
    }


    /* *
     * @Route("/user/{id}" , methods={"GET"})
     * @param $id
     * @return JsonResponse
     */
/*
    public function showUser($id)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        if (empty($user)) {
            $response = array(
                'message' => 'user not found',
                'error' => null,
                'result' => null
            );

            return new JsonResponse($response);
        }

        $data = $serializer->serialize($user, 'json');

        $response = array(

            'result' => json_decode($data)

        );

        return new JsonResponse($response);

    }
*/

    /* *
     * @Route("/users", methods={"GET"})
     */


/*
    public function listUser()
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);


        $users=$this->getDoctrine()->getRepository(User::class)->findAll();

        if (!count($users)){
            $response=array(
                'message'=>'No users found!',
                'errors'=>null,
                'result'=>null

            );

            return new JsonResponse($response);
        }



// Serialize your object in Json
       // $jsonObject = $serializer->serialize($users, 'json', [
          //  'circular_reference_handler' => function ($users) {

             //   return $users->getId();
           // }
    //    ]);

// For instance, return a Response with encoded Json
       // return new JsonResponse($jsonObject, 200, ['Content-Type' => 'application/json']);

      //  $data = $serializer -> serialize($users,'json');

      //  $response=array(
        //    'result'=>json_decode($data)

    //    );


     //   return new JsonResponse($response);

    }

*/
}
