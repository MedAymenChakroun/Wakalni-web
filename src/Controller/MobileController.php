<?php

namespace App\Controller;
use App\Entity\Review;
use App\Entity\Reclamation;
use App\Entity\Livraison;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Entity\Commande;

use App\Entity\User;
use Doctrine\DBAL\SQL\Parser\Exception;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;



class MobileController extends AbstractController
{
    /**
     * @Route("mobile/signup", name="mobile_signup")
     */

    public function signupAction(Request $request, UserPasswordEncoderInterface $passwordEncoder){

        $email = $request->query->get("email");
        $password = $request->query->get("password");
        $firstname = $request->query->get("firstname");
        $lastname = $request->query->get("lastname");
        $roles = $request->query->get("roles");
        $age = $request->query->get("age");
        $phonenumber = $request->query->get("phonenumber");
        $image = $request->query->get("image");

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return new Response("email invalide");
        }
        $user = new User();
        $user->setEmail($email);
        $user->setPassword($passwordEncoder->encodePassword(
            $user,
            $password
        ));
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setRoles(array($roles));
        $user->setAge($age);
        $user->setPhonenumber($phonenumber);
        $user->setImage($image);

        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return new JsonResponse("account created", 200);
        }
        catch(Exception $ex){
            return new Response("exception".$ex->getMessage());
        }
    }

    /**
     * @Route("mobile/login", name="mobile_login")
     */
    Public function loginAction(Request $request){
        $email = $request->query->get("email");
        $password = $request->query->get("password");

        $em=$this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['email'=>$email]);

        if($user){
            if(password_verify($password,$user->getpassWord())){
                $serializer = new Serializer([new ObjectNormalizer()]);
                $formatted = $serializer->normalize($user);
                return new JsonResponse($formatted);
            }
            else {
                return new Response("password not found");
            }
        }
        else {
            return new Response("user not found");
        }
    }

    /**
     * @Route("mobile/edit/{id}", name="mobile_edit")
     */
    Public function editUserAction($id, Request $request, UserPasswordEncoderInterface $passwordEncoder){

        $email = $request->query->get("email");
        $password = $request->query->get("password");
        $firstname = $request->query->get("firstname");
        $lastname = $request->query->get("lastname");
        $age = $request->query->get("age");
        $phonenumber = $request->query->get("phonenumber");

        $em=$this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return new Response("email invalide");
        }
        $user->setEmail($email);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setAge($age);
        $user->setPhonenumber($phonenumber);

        try {
            $em->persist($user);
            $em->flush();

            return new JsonResponse("success", 200);
        }
        catch(Exception $ex){
            return new Response("failed".$ex->getMessage());
        }
    }

    /**
     * @Route("mobile/cuser", name="mobile_cuser")
     */
    Public function getCurrentUser(Request $request){
        $id = $request->query->get("id");
        $em=$this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        if($user){
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($user);
            return new JsonResponse($formatted);
            }
        else {
            return new Response("user");
        }
    }

    /**
     * @Route("mobile/deactivate", name="mobile_deavtivate")
     */
    Public function desactivateUser(Request $request){
        $id = $request->query->get("id");
        $em=$this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        if($user!=null ) {
            $em->remove($user);
            $em->flush();
            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("user deleted.");
            return new JsonResponse($formatted);

        }
        return new JsonResponse("id user invalide.");
    }
    /**
     * @Route("mobile/editpassword", name="mobile_editpassword")
     */
    Public function editPasswordAction(Request $request, UserPasswordEncoderInterface $passwordEncoder){

        $id = $request->query->get("id");
        $password = $request->query->get("password");
        $em=$this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $user->setPassword($passwordEncoder->encodePassword(
            $user,
            $password
        ));
        try {
            $em->persist($user);
            $em->flush();

            return new JsonResponse("success", 200);
        }
        catch(Exception $ex){
            return new Response("failed".$ex->getMessage());
        }
    }

    /**
     * @Route("mobile/getidbyemail", name="mobile_getidbyemail")
     */
    Public function getUserByMail(Request $request){
        $email = $request->query->get("email");
        $em=$this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['email'=>$email]);

        if($user){
                $serializer = new Serializer([new ObjectNormalizer()]);
                $formatted = $serializer->normalize($user->getId());
                return new JsonResponse($formatted);
            }
        else {
            return new Response("user not found");
        }
    }

 /**
 * @Route("mobile/displayproduit",name="display_produit")
 */
public function displayproduit(){
    $produit =$this->getDoctrine()->getManager()->getRepository(Produit::class)->findAll();
    $serializer=new Serializer([new ObjectNormalizer()]);
    $formatted =$serializer->normalize($produit, null, [AbstractNormalizer::ATTRIBUTES => ['produitid','nom','type','prix','crid'=> ['firstname']]]);
    return new JsonResponse($formatted);
    
    }
   /**
 * @Route("mobile/displaycommande",name="display_commande")
 */
public function displaycommande(){
    $commande =$this->getDoctrine()->getManager()->getRepository(commande::class)->findAll();
    $serializer=new Serializer([new ObjectNormalizer()]);
    $formatted =$serializer->normalize($commande, null, [AbstractNormalizer::ATTRIBUTES => ['panierid'=> ['quantite','prixprod'] ,'clientid' => ['firstname']]]);
    return new JsonResponse($formatted);
    
    }
        /**
 * @Route("mobile/displaypanier",name="mobile_display_panier")
 */
public function displaypanier(){
    $panier =$this->getDoctrine()->getManager()->getRepository(panier::class)->findAll();
    $serializer=new Serializer([new ObjectNormalizer()]);
    $formatted =$serializer->normalize($panier, null, [AbstractNormalizer::ATTRIBUTES => ['panierid','quantite','produitid'=> ['nom','prix'] ,]]);
    return new JsonResponse($formatted);
    
    }
  /**
     * @Route("mobile/addpanier", name="mobile_panier")
     * @Method("POST")
     */

    public function addpanier(Request $request)
    {
        $panier = new Panier();
        $produitid = $request->query->get("produitid");
        $clientid = $request->query->get("clientid");
        $quantite = $request->query->get("quantite");
        $prixprod = $request->query->get("prixprod");
        $em = $this->getDoctrine()->getManager();
        $panier->setProduitid($em->getRepository(Produit::class)->find($produitid));
        $panier->setClientid($em->getRepository(User::class)->find($clientid));
        $panier->setQuantite($quantite);
        $panier->setPrixprod($prixprod);
        $em->persist($panier);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($panier);
        return new JsonResponse($formatted);
    }
    /**
     * @Route("mobile/addcommande", name="mobile_addcommande")
     * @Method("POST")
     */

    public function addcommande(Request $request)
    {
        $commande = new Commande();
        $datecreation = $request->query->get("datecreation");
        $dateexpedition = $request->query->get("dateexpedition");
        $datearivee = $request->query->get("datearivee");
        $panierid = $request->query->get("panierid");
        $clientid = $request->query->get("clientid");

        $em = $this->getDoctrine()->getManager();
        $commande->setDatecreation(new \DateTime($datecreation));
        $commande->setDateexpedition(new \DateTime($dateexpedition));
        $commande->setDatearrivee(new \DateTime($datearivee));
        $commande->setPanierid($em->getRepository(Panier::class)->find($panierid));
        $commande->setClientid($em->getRepository(User::class)->find($clientid));

        $em->persist($commande);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($commande);
        return new JsonResponse($formatted);
    }
       /******************Ajouter Reclamation*****************************************/
    /**
     * @Route("/mobile/addreclamation", name="add_reclamation")
     * @Method("POST")
     */

    public function ajouterReclamationAction(Request $request)
    {
        $reclamation = new Reclamation();
        $em = $this->getDoctrine()->getManager();
        $sujet = $request->query->get("sujet");
        $contenu = $request->query->get("contenu");
        $etat = $request->query->get("etat");
        $commandeid = $em->getRepository(Commande::class)->find($request->query->get("commandeid"));
        $clientid = $em->getRepository(User::class)->find($request->query->get("clientid"));


        $reclamation->setSujet($sujet);
        $reclamation->setContenu($contenu);
        $reclamation->setEtat($etat);
        $reclamation->setCommandeid($commandeid);
        $reclamation->setClientid($clientid);

        $em->persist($reclamation);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($reclamation);
        return new JsonResponse($formatted);

    }

    /******************Supprimer Reclamtion*****************************************/

    /**
     * @Route("/mobile/deletereclamation", name="delete_reclamation")
     * @Method("DELETE")
     */

    public function deleteReclamationAction(Request $request) {
        $id = $request->get("id");

        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository(Reclamation::class)->find($id);
        if($reclamation!=null ) {
            $em->remove($reclamation);
            $em->flush();

            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("Reclamation a ete supprimee avec success.");
            return new JsonResponse($formatted);

        }
        return new JsonResponse("id Reclamation invalide.");


    }

    /******************Modifier Reclamation*****************************************/
    /**
     * @Route("/mobile/updatereclamation", name="update_reclamation")
     * @Method("PUT")
     */
    public function modifierReclamationAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $reclamation = $this->getDoctrine()->getManager()
            ->getRepository(Reclamation::class)
            ->find($request->get("id"));

        $reclamation->setSujet($request->get("sujet"));
        $reclamation->setContenu($request->get("contenu"));
        $reclamation->setEtat($request->get("etat"));
        $reclamation->setCommandeid($em->getRepository(Commande::class)->find($request->query->get("commandeid")));
        $reclamation->setClientid($em->getRepository(User::class)->find($request->query->get("clientid")));

        $em->persist($reclamation);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($reclamation);
        return new JsonResponse("reclamation a ete modifiee avec success.");

    }



    /******************affichage Reclamation*****************************************/

    /**
     * @Route("/mobile/displayreclamation", name="display_reclamation")
     */
    public function allReclamationAction()
    {

        $reclamation = $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($reclamation, null, [AbstractNormalizer::ATTRIBUTES => ['reclamationid','sujet','contenu','etat','commandeid' => ['commandeid'],'clientid' => ['email','id']]]);

        return new JsonResponse($formatted);

    }

    /******************Ajouter Review*****************************************/
    /**
     * @Route("/mobile/addreview", name="add_review")
     * @Method("POST")
     */

    public function ajouterReviewAction(Request $request)
    {
        $review = new Review();
        $em = $this->getDoctrine()->getManager();
        $note = $request->query->get("note");
        $commentaire = $request->query->get("comment");
        $produitid = $em->getRepository(Produit::class)->find($request->query->get("productid"));
        $clientid = $em->getRepository(User::class)->find($request->query->get("clientid"));


        $review->setNote($note);
        $review->setCommentaire($commentaire);
        $review->setProduitid($produitid);
        $review->setUtilisateurid($clientid);

        $em->persist($review);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($review);
        return new JsonResponse($formatted);

    }

    /******************Supprimer Review*****************************************/

    /**
     * @Route("/mobile/deletereview", name="delete_review")
     * @Method("DELETE")
     */

    public function deleteReviewAction(Request $request) {
        $id = $request->get("id");

        $em = $this->getDoctrine()->getManager();
        $review = $em->getRepository(Review::class)->find($id);
        if($review!=null ) {
            $em->remove($review);
            $em->flush();

            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("Review a ete supprimee avec success.");
            return new JsonResponse($formatted);

        }
        return new JsonResponse("id Review invalide.");


    }

    /******************Modifier Review*****************************************/
    /**
     * @Route("/mobile/updatereview", name="update_review")
     * @Method("PUT")
     */
    public function modifierReviewAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $review = $this->getDoctrine()->getManager()
            ->getRepository(Review::class)
            ->find($request->get("id"));

        $review->setNote($request->get("note"));
        $review->setCommentaire($request->get("comment"));
        $review->setProduitid($em->getRepository(Produit::class)->find($request->query->get("produitid")));
        $review->setUtilisateurid($em->getRepository(User::class)->find($request->query->get("clientid")));

        $em->persist($review);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($review);
        return new JsonResponse("review a ete modifiee avec success.");

    }



    /******************affichage Review*****************************************/

    /**
     * @Route("/mobile/displayreview", name="display_review")
     */
    public function allReviewAction()
    {

        $reclamation = $this->getDoctrine()->getManager()->getRepository(Review::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($reclamation, null, [AbstractNormalizer::ATTRIBUTES => ['reviewid','note','commentaire','produitid' => ['produitid','nom'] ,'utilisateurid' => ['id','email']]]);

        return new JsonResponse($formatted);

    }

        /******************affichage Livraison*****************************************/

    /**
     * @Route("/mobile/displaylivraison", name="mobile_display_livraison")
     */
    public function allLivraisonAction()
    {

        $livraison = $this->getDoctrine()->getManager()->getRepository(Livraison::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($livraison, null, [AbstractNormalizer::ATTRIBUTES => ['id','idlivreur' => ['id','firstname','lastname','phonenumber'],'idcommande' => ['id','clientid'=> ['id','email']]]]);

        return new JsonResponse($formatted);

    }
}