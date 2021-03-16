<?php

class Meta extends Entity {


}


/**
 * @deprecated use metaXxx functions.
 * @return Meta
 */
function meta(): Meta {
    return new Meta();
}