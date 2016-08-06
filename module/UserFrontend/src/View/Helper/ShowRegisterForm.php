<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace UserFrontend\View\Helper;

/**
 * Class ShowRegisterForm
 *
 * @package UserFrontend\View\Helper
 */
class ShowRegisterForm extends AbstractShowForm
{
    /**
     * Output the register form
     *
     * @param string $formClass
     *
     * @return
     */
    public function __invoke($formClass = 'form-horizontal')
    {
        $this->getUserForm()->setAttribute(
            'action',
            $this->getView()->url('user-frontend/register', [], true)
        );

        return $this->getView()->bootstrapForm(
            $this->getUserForm(), [], $formClass
        );
    }
}
