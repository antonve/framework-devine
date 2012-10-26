<?php

// helpers.php - contains some useful functions
// By Anton Van Eechaute

function trace($data)
{
    echo '<pre class="debug_trace">';
    var_dump($data);
    echo '</pre>';
}