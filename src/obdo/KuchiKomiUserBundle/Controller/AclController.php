<?php

namespace obdo\KuchiKomiUserBundle\Controller;

// pour la gestion des acls
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

/**
 * Description of AclController
 * Gestion des acl
 * parametre l'objet à protéger/contrôler
 * parametre l'utilisateur qui demande l'accés/ pour lequel on créé un accés
 * @author frederic
 */
class AclController {

    public static function addAcl($objet, $user, $context) {
        // création de l'ACL
        $aclProvider = $context->get('security.acl.provider');
        $objectIdentity = ObjectIdentity::fromDomainObject($objet);
        // si acl existe pas de création
        try {
            $acl = $aclProvider->findAcl($objectIdentity);
        } catch (\Exception $e) {
            $acl = $aclProvider->createAcl($objectIdentity);
        }
        $securityIdentity = UserSecurityIdentity::fromAccount($user);

        // donne accès au user 
        $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
        $aclProvider->updateAcl($acl);
    }
    
    /*
     * Retourne les objets apartennant à la table $objet transmise en entrée
     * et pour lesquels l'utilisatuer $user a des droits.
     */
    public static function lstObj($user, $objet, $provider) {

        $securityId = UserSecurityIdentity::fromAccount($user);

        $liste = array();
        for ($i = 0; $i < count($objet); $i++) {
            try {
                $acl = $provider->findAcl(ObjectIdentity::fromDomainObject($objet[$i]));

                foreach ($acl->getObjectAces() as $ace) {
                    if ($ace->getSecurityIdentity()->equals($securityId)) {
                        $liste[] = $objet[$i];
                    }
                }
            } catch (\Exception $e) {
                
            }
        }

        return $liste;
    }

}
