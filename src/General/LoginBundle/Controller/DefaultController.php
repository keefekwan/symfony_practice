<?php

namespace General\LoginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use General\LoginBundle\Entity\Users;
use General\LoginBundle\Modals\Login;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $session = $this->get('request_stack')->getCurrentRequest()->getSession(); // Session object obtained by request method

        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository('GeneralLoginBundle:Users');

        if ($request->getMethod() == 'POST') { // Where the login actually happens

            $session->clear();

            $username = $request->get('jdoe');
            $password = sha1($request->get('password'));
            $remember = $request->get('remember');

            $user = $repository->findOneBy(array(
                'userName' => $username,
                'password' => $password,
            ));

            if ($user) { // Validation for if the user is valid
                if ($remember == 'remember-me') { // If the login happens and the remember box is checked create a new login object
                    $login = new Login();
                    $login->setUsername($username);
                    $login->setPassword($password);

                    $session->set('login', $login);

                }

                if ($user) { // If user is validate redirect to welcome page
                    $page = $request->get('page');

                    $count_per_page = 50;
                    $total_count = $this->getTotalCountries();
                    $total_pages = ceil($total_count/$count_per_page);

                    if (!is_numeric($page)) {
                        $page = 1;
                    } else {
                        $page = floor($page);
                    }

                    if ($total_count <= $count_per_page) {
                        $page = 1;
                    }

                    if (($page * $count_per_page) > $total_count) {
                        $page = $total_pages;
                    }

                    $offset = 0;

                    if ($page > 1) {
                        $offset = $count_per_page * ($page - 1);
                    }

                    $em = $this->getDoctrine()->getManager();

                    $ctryQuery = $em->createQueryBuilder()
                        ->select('c')
                        ->from('GeneralLoginBundle:Country', 'c')
                        ->setFirstResult($offset)
                        ->setMaxResults($count_per_page);

                    $ctryFinalQuery = $ctryQuery->getQuery();

                    $countries = $ctryFinalQuery->getArrayResult();

                    // exit(\Doctrine\Common\Util\Debug::dump($countries));

                    return $this->render('GeneralLoginBundle:Default:welcome.html.twig', array(
                        'name'        => $user->getFirstName(),
                        'countries'   => $countries,
                        'total_pages' => $total_pages,
                        'current_page' => $page,
                    ));
                }
//                return $this->render('GeneralLoginBundle:Default:welcome.html.twig', array(
//                    'name' => $user->getFirstName(),
//                ));
            } else {
                return $this->render('GeneralLoginBundle:Default:login.html.twig', array(
                    'name' => 'Login failed',
                ));
            }
        } else { // Checks if the session has the remember box checked and has the login object in the session

            if ($session->has('login')) {
                $login = $session->get('login');
                $username = $login->getUsername();
                $password = $login->getPassword();

                $user = $repository->findOneBy(array( // Validation for username and password by using entity manager
                    'userName' => $username,
                    'password' => $password,
                ));

                if ($user) { // If user is validate redirect to welcome page
                    $page = $request->get('page');

                    $count_per_page = 50;
                    $total_count = $this->getTotalCountries();
                    $total_pages = ceil($total_count/$count_per_page);

                    if (!is_numeric($page)) {
                        $page = 1;
                    } else {
                        $page = floor($page);
                    }

                    if ($total_count <= $count_per_page) {
                        $page = 1;
                    }

                    if (($page * $count_per_page) > $total_count) {
                        $page = $total_pages;
                    }

                    $offset = 0;

                    if ($page > 1) {
                        $offset = $count_per_page * ($page - 1);
                    }

                    $em = $this->getDoctrine()->getManager();

                    $ctryQuery = $em->createQueryBuilder()
                        ->select('c')
                        ->from('GeneralLoginBundle:Country', 'c')
                        ->setFirstResult($offset)
                        ->setMaxResults($count_per_page);

                    $ctryFinalQuery = $ctryQuery->getQuery();

                    $countries = $ctryFinalQuery->getArrayResult();

                    // exit(\Doctrine\Common\Util\Debug::dump($countries));

                    return $this->render('GeneralLoginBundle:Default:welcome.html.twig', array(
                        'name'        => $user->getFirstName(),
                        'countries'   => $countries,
                        'total_pages' => $total_pages,
                        'current_page' => $page,
                    ));
                }
            }

            return $this->render('GeneralLoginBundle:Default:login.html.twig');
        }
//        exit(\Doctrine\Common\Util\Debug::dump($user));
    }

    public function getTotalCountries()
    {
        $em = $this->getDoctrine()->getManager();

        $countQuery = $em->createQueryBuilder()
            ->select('Count(c)')
            ->from('GeneralLoginBundle:Country', 'c');

        $finalQuery = $countQuery->getQuery();

        $total = $finalQuery->getSingleScalarResult();

        return $total;
    }

    public function signupAction(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            $username = $request->get('username');
            $firstname = $request->get('firstname');
            $password = $request->get('password');

            $user = new Users();
            $user->setFirstName($firstname);
            $user->setPassword(sha1($password));
            $user->setUserName($username);
            $em = $this->getDoctrine()->getManager();

            $em->persist($user);
            $em->flush();

        }

        return $this->render('GeneralLoginBundle:Default:signup.html.twig');
    }

    public function logoutAction(Request $request)
    {
        $session = $this->get('request_stack')->getCurrentRequest()->getSession();

        $session->clear();

        return $this->render('GeneralLoginBundle:Default:login.html.twig');
    }
}
