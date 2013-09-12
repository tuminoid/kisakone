<?php
/**
 * Processes the change edit tournament form
 * 
 * @package kisakone_inputprocessing
 * */

/**
 * Processes the edit tournament form
 * @return Nothing or Error object on error
 */
function processForm() {
     
    require_once('core/textcontent.php');
    
    $problems = array();
    
    $event = GetEventDetails(@$_GET['id']);
    if (!$event) return Error::NotFound('event');
    if (!IsAdmin() && $event->management !='td') return Error::AccessDenied();
 
    
    if (@$_POST['cancel']) {

        header("Location: " . url_smarty(array('page' => 'manageevent', 'id' => @$_GET['id']), $custom));               
        die();
    }    
    
    $title = @$_POST['title'];
    $content = @$_POST['textcontent'];
    
    
    
    
    if(count($problems)) {
        $error = new Error();
        $error->title = translate('title_is_mandatory');
        $error->function = 'InputProcessing:edit_event_page:processForm';
        $error->cause = array_keys($problems);
        $error->data = $problems;
        return $error;
    }
    

    $evp = new TextContent(array());

    $evp->title = $title;
    $evp->content = $content;
    
    
    if (!@$_POST['preview']) {
       input_emails(@$_POST['ids'], $evp, $event);
    } else {
        $evp->FormatText();        
        return $evp;
    }
    
    
    
    //if (is_a($result, 'Error')) return $result;
    
    header("Location: " . url_smarty(array('page' => 'manageevent', 'id' => @$_GET['id']), $custom));               
       die();
        
   
}

function input_emails($recipientlist, $mail, $event) {
    $recipients = explode(',', $recipientlist);
    require_once('core/email.php');
    $email = new Email($mail);
    $link = "http://" . $_SERVER['HTTP_HOST'] . url_smarty(array('page' => 'event', 'id' => $event->id, 'view' => 'payment'), $link);
    $special = array('link' => $link);
    
    foreach ($recipients as $uid) {
        $u = GetUserDetails($uid);
        
        $p = $u->GetPlayer();
        $email->Prepare($u, $p, $event, $special);
        $email->Send($p->email);
        
    }
}

?>