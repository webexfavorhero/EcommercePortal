<?php
namespace Findmyrice\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Identical;
use Phalcon\Validation\Validator\StringLength;

class SignUpContributorForm extends Form
{

    public function initialize($entity = null, $options = null)
    {

        // First Name
        $first_name = new Text('first_name', array(
            'class'=>"form-control",
            'placeholder'=>"First Name"
        ));
        $first_name->setLabel('First Name');
        $first_name->addValidators(array(
            new PresenceOf(array(
                'message' => 'The First Name is required'
            ))
        ));
        $this->add($first_name);



        // Email
        $email = new Text('email', array(
            'class'=>"form-control",
            'placeholder'=>"Email Address"
        ));
        $email->setLabel('E-Mail');
        $email->addValidators(array(
            new PresenceOf(array(
                'message' => 'The e-mail is required'
            )),
            new Email(array(
                'message' => 'The e-mail is not valid'
            ))
        ));
        $this->add($email);


        // Password
        $password = new Password('password', array(
            'class'=>"form-control",
            'placeholder'=>"Password"
        ));
        $password->setLabel('Password');
        $password->addValidators(array(
            new PresenceOf(array(
                'message' => 'The password is required'
            )),
            new StringLength(array(
                'min' => 8,
                'messageMinimum' => 'Password is too short. Minimum 8 characters'
            ))
        ));
        $this->add($password);


        //Content Type
        $content_type = new Select('content_type', array(
            '' => 'Content Type',
            'Content Type 1' => 'Content Type 1',
            'Content Type 2' => 'Content Type 2',
            'Content Type 3' => 'Content Type 3'
        ),
            array('class'=>'form-control')
        );
        $content_type->setLabel('Content Type');
        $content_type->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Content Type is required'
            ))
        ));
        $this->add($content_type);

        // CSRF
        $csrf = new Hidden('csrf_contributor_set_up');

        $csrf->addValidator(new Identical(array(
            'value' => $this->security->getSessionToken(),
            'message' => 'CSRF validation failed'
        )));

        $this->add($csrf);

        // Sign Up User
        $this->add(new Submit('Register', array(
            'class' => 'red_btn register_btn'
        )));
    }

    /**
     * Prints messages for a specific element
     */
    public function messages($name)
    {
        if ($this->hasMessagesFor($name)) {
            foreach ($this->getMessagesFor($name) as $message) {
                $this->flash->error($message);
            }
        }
    }
}
