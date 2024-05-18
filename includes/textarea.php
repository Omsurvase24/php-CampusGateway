<?php

function customTextarea($label, $name, $rows, $placeholder="", $value="", $width="min-w-[300px]") {
    $textarea = "<div>";
    $textarea .= "<label class='text-sm text-neutral-400'>$label</label>";
    $textarea .= "<textarea rows='$rows' name='$name' id='$name' placeholder='$placeholder' autocomplete='false' class='flex w-full rounded-md bg-neutral-700 border border-transparent px-3 py-3 text-sm font-medium file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-400 disabled:cursor-not-allowed disabled:opacity-50 focus:outline-none text-white $width'>$value</textarea>";
    $textarea .= "</div>"; 

    return $textarea;
}

?>