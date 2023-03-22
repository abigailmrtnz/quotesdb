<?php
function isValid($id, $model) { //can name isValid whatever
    $model->id = $id;
    return ($model->read_single() > 0) ? true : false;
}
?>