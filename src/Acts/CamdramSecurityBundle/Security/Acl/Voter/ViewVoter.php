<?php
namespace Acts\CamdramSecurityBundle\Security\Acl\Voter;

use Acts\CamdramBundle\Entity\Entity;
use Acts\CamdramBundle\Entity\Show;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class ViewVoter implements VoterInterface
{

    public function supportsAttribute($attribute)
    {
        return $attribute == 'VIEW';
    }

    public function vote(TokenInterface $token, $object, array $attributes)
    {
        if ($attributes == array('VIEW')) {
            if ($object instanceof Show) {
                if ($object->getAuthorisedBy() !== null) {
                    return self::ACCESS_GRANTED;
                }
            }
            elseif ($object instanceof Entity) {
                return self::ACCESS_GRANTED;
            }
        }

        return self::ACCESS_ABSTAIN;
    }

    /**
     * You can override this method when writing a voter for a specific domain
     * class.
     *
     * @param string $class The class name
     *
     * @return Boolean
     */
    public function supportsClass($class)
    {
        return $class == 'Acts\\CamdramBundle\\Entity\\Entity';
    }
}
