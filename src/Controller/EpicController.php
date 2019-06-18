<?php

namespace App\Controller;

use App\Entity\Epic;
use App\Form\EpicType;
use App\Repository\EpicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class EpicController extends AbstractController
{

    public function CreateEpic(Request $request)
    {
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
            $em = $this->getDoctrine()->getManager();

            if ($parametersAsArray != null) {



                $epic = new Epic();

                $project_id = $parametersAsArray['project_id'];

                $project = $this->getDoctrine()->getManager()->getRepository(Project::class)->find($project_id);

                $epic->setName($parametersAsArray['name']);
                $epic->setDuree($parametersAsArray['duree']);
                $epic->setDescription($parametersAsArray['description']);
                $epic->setSommeComplex($parametersAsArray['sommeComplex']);
                $epic->setProjs($project);


                $em->persist($epic);
                $em->flush();

                $data = array(
                    "data" => "epic created !",
                    'error' => null,
                    'result' => null
                );


            }else {
                $data = array(
                    "data" => "Failed !",
                    'error' => 'send data to create an epic',
                    'result' => null
                );


            }
        }

        return new JsonResponse($data);
    }


    public function showEpic($id)
    {

            $epic = $this->getDoctrine()->getRepository(Epic::class)->find($id);


            if (empty($epic)) {

                $response = array(
                    'message' => 'Epic not found',
                    'error' => null,
                    'result' => null
                );

                return new JsonResponse($response);
            }

            $data = $this->get('jms_serializer')->serialize($epic, 'json');


            $response = array(
                'message' => 'success',
                'errors' => null,
                'result' => json_decode($data)

            );

            return new JsonResponse($response);


    }


    public function UpdateEpic($id,Request $request)
    {
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
            $em = $this->getDoctrine()->getManager();


            if ($parametersAsArray != null) {


                $epicUpdate=$this->getDoctrine()->getRepository(Epic::class)->find($id);

                //$project_id= $parametersAsArray['project_id'];

              //  $projet=$this->getDoctrine()->getManager()->getRepository('ScrumBundle:Project')->find($project_id);

                $epicUpdate->setName($parametersAsArray['name']);
                $epicUpdate->setDescription($parametersAsArray['description']);
                $epicUpdate->setSommeComplex($parametersAsArray['sommeComplex']);
                $epicUpdate->setDuree($parametersAsArray['duree']);
              //  $epicUpdate->setEpics($projet);


                $em->persist($epicUpdate);
                $em->flush();

                $data = array(
                        "data" => "epic updated !",
                        'error' => null,
                        'result' => null
                );
                } else {
                    $data = array(
                        "data" => "parameters failed",
                        'error' => null,
                        'result' => null
                    );

                }


            }

        return new JsonResponse($data);



    }

    public function deleteEpic($id)
    {

            $epic=$this->getDoctrine()->getRepository(Epic::class)->find($id);

            if (empty($epic)) {

                $response=array(
                    'message'=>'epic Not found !',
                    'errors'=>null,
                    'result'=>null
                );

                return new JsonResponse($response);
            }

            $em=$this->getDoctrine()->getManager();
            $em->remove($epic);
            $em->flush();
            $response=array(
                'message'=>'epic deleted !',
                'errors'=>null,
                'result'=>null
            );

            return new JsonResponse($response);


    }
}
