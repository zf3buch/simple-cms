<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace UserFrontend\Form;

/**
 * Class UserLogoutForm
 *
 * @package UserFrontend\Form
 */
class UserLogoutForm extends AbstractUserForm
    implements UserLogoutFormInterface
{
    /**
     * Init form
     */
    public function init()
    {
        $this->setName('user_logout_form');
        $this->setAttribute('class', 'form-horizontal');

        $this->addCsrfElement();
        $this->addSubmitElement(
            'logout_user', 'user_frontend_action_logout'
        );

        $this->setValidationGroup(array_keys($this->getElements()));
    }
}
