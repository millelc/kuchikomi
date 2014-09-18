<?php

namespace obdo\ServicesBundle\Services;

use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class AclManager
{
    private $container;

    public function __construct($kernel)
    {
        $this->container = $kernel->getContainer();
    }

    public function addAcl($objet, $user) 
    {
        // création de l'ACL
        $aclProvider = $this->container->get('security.acl.provider');
        $objectIdentity = ObjectIdentity::fromDomainObject($objet);
        // si acl existe pas de création
        try 
        {
            $acl = $aclProvider->findAcl($objectIdentity);
        } 
        catch (\Exception $e) 
        {
            $acl = $aclProvider->createAcl($objectIdentity);
        }
        $securityIdentity = UserSecurityIdentity::fromAccount($user);

        // donne accès au user 
        $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
        $aclProvider->updateAcl($acl);
    }
    
    public function deleteAcl( $user )
    {
        $aclProvider = $this->container->get('security.acl.provider');
        $objectIdentity = ObjectIdentity::fromDomainObject($user);
        $aclProvider->deleteAcl($objectIdentity);
    }
    
    /*
     * Retourne les objets apartennant à la table $objet transmise en entrée
     * et pour lesquels l'utilisatuer $user a des droits.
     */
    public function lstObj($user, $objet) 
    {
        $provider = $this->container->get('security.acl.provider');
        
        $securityId = UserSecurityIdentity::fromAccount($user);

        $liste = array();
        for ($i = 0; $i < count($objet); $i++) 
        {
            try 
            {
                $acl = $provider->findAcl(ObjectIdentity::fromDomainObject($objet[$i]));

                foreach ($acl->getObjectAces() as $ace) 
                {
                    if ($ace->getSecurityIdentity()->equals($securityId)) 
                    {
                        $liste[] = $objet[$i];
                    }
                }
            } 
            catch (\Exception $e) 
            {
                
            }
        }

        return $liste;
    }

}
