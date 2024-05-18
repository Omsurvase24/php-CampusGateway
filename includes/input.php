<?php

function customInput($label, $type, $name, $placeholder="", $value="", $width="min-w-[300px]", $required=false, $fileAccept="application/pdf") {
    $input = "<div>";
    $input .= "<label class='text-sm text-neutral-400'>$label</label>";
    $input .= "<input type='$type' name='$name' id='$name' placeholder='$placeholder' value='$value' autocomplete='false' class='flex w-full rounded-md bg-neutral-700 border border-transparent px-3 py-3 text-sm font-medium file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-neutral-400 placeholder:text-neutral-400 disabled:cursor-not-allowed disabled:opacity-50 focus:outline-none text-white $width'";
    $input .= $type == 'file' ? "accept='$fileAccept'>" : ">";
    $input .= "</div>"; 

    return $input;
}

?>