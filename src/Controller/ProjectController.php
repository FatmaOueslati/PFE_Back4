<?php

namespace App\Controller;

use App\Entity\Project;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Validator\Constraints\DateTime;


class ProjectController extends Controller
{


    public function showProject($id)
    {

            $project = $this->getDoctrine()->getRepository(Project::class)->find($id);

            if (empty($project)) {
                $data = array(
                    'message' => 'project not found',
                    'error' => null,
                    'result' => null
                );

                return new JsonResponse($data);

            }

            $data = $this->get('jms_serializer')->serialize($project, 'json');


            $response = array(

                'message' => 'success',
                'errors' => null,
                'result' => json_decode($data)

            );

            return new JsonResponse($response);


    }


    public function CreateProject(Request $request)
    {
           $data=[];
          // $stat='en cours';
        if ($content = $request->getContent()) {
                $parametersAsArray = json_decode($content, true);

                if ($parametersAsArray != null) {

                    $project = new Project();

                    $em = $this->getDoctrine()->getManager();

                    $project->setName($parametersAsArray['name']);
                    $project->setDescription($parametersAsArray['description']);
                   //$project->setStatut($stat);
                    $project->setDateDebut(new \DateTime($parametersAsArray['dateDebut']));
                    $project->setDateFin(new \DateTime($parametersAsArray['dateFin']));


                    $em->persist($project);
                    $em->flush();


                    $data = array(
                        "data" => "project created",
                        'errors' => null,
                        'result' => null
                    );
                } else {
                    $data = array(
                        "data" => "parameters failed",
                        'errors' => null,
                        'result' => null
                    );


                }


        }

        return new JsonResponse($data);
    }



    public function listProject()
    {

            $projects=$this->getDoctrine()->getRepository(Project::class)->findAll();

            if (!count($projects)){
                $response=array(

                    'message'=>'No projects found!',
                    'errors'=>null,
                    'result'=>null

                );

                return new JsonResponse($response);
            }


            $data=$this->get('jms_serializer')->serialize($projects,'json');

            $response=array(

                'message'=>'success',
                'errors'=>null,
                'result'=>json_decode($data)

            );

            return new JsonResponse($response);

    }





    public function UpdateProject($id, Request $request)
    {
        $data=[];
            if ($content = $request->getContent()) {

                $parametersAsArray = json_decode($content, true);

                if ($parametersAsArray != null) {

                    $project = $this->getDoctrine()->getRepository(Project::class)->find($id);

                    $em = $this->getDoctrine()->getManager();


                    $project->setName($parametersAsArray['name']);
                    $project->setDescription($parametersAsArray['description']);
                    $project->setDateDebut(new DateTime($parametersAsArray['dateDebut']));
                    $project->setDateFin(new DateTime($parametersAsArray['dateFin']));


                    $em->persist($project);
                    $em->flush();

                    $data = array(
                        "data" => "project updated",
                        'errors' => null,
                        'result' => null
                    );
                } else {
                    $data = array(
                        'data' => "failed",
                        'errors' => "send data to update the project",
                        'result' => null
                    );


                }

            }

        return new JsonResponse($data);
    }


    public function deleteProject($id)
    {

            $project=$this->getDoctrine()->getRepository(Project::class)->find($id);

            if (empty($project)) {

                $response=array(
                    'message'=>'failed',
                    'errors'=>'project Not found !',
                    'result'=>null
                );

                return new JsonResponse($response);
            }

            $em=$this->getDoctrine()->getManager();
            $em->remove($project);
            $em->flush();

            $response=array(
                'message'=>'project deleted !',
                'errors'=>null,
                'result'=>null
            );

            return new JsonResponse($response);

    }




    public function ArchiveProject($id, Request $request)
    {
        $data=[];
        if ($content = $request->getContent()) {

            $parametersAsArray = json_decode($content, true);

            if ($parametersAsArray != null) {

                $project = $this->getDoctrine()->getRepository(Project::class)->find($id);

                $em = $this->getDoctrine()->getManager();


                $project->setStatut($parametersAsArray['statut']);

                $em->persist($project);
                $em->flush();

                $data = array(
                    "data" => "project archived",
                    'errors' => null,
                    'result' => null
                );
            } else {
                $data = array(
                    'data' => "failed",
                    'errors' => "there in nothing to update",
                    'result' => null
                );


            }

        }

        return new JsonResponse($data);
    }
}
