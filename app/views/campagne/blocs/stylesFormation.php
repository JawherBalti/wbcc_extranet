<?php
/**
 * Bloc styles CSS pour formation
 */
?>
<style>
.step {
    display: none;
}

.step.active {
    display: block;
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

.buttons {
    margin-top: 20px;
    display: flex;
    justify-content: space-between;
}

button {
    padding: 10px 20px;
    border: none;
    border-radius: 20px;
    font-size: 16px;
}

.btn-prev {
    background-color: rgb(78, 123, 172);
    color: #ffffff;
}

.btn-next {
    background-color: #007BFF;
    color: white;
}

.btn-finish {
    background-color: green;
    color: white;
}

.hidden {
    display: none;
}


#sinistreForm {
    font-size: 18px;
}


/******************** */

.tooltip-container {
    position: relative;
    display: inline-block;
    cursor: pointer;
}

.tooltip-content {
    position: absolute;
    bottom: 125%;
    left: 50%;
    transform: translateX(-50%);
    background-color: #D3D3D3;
    border: 2px solid #36b9cc;
    color: black;
    padding: 16px 20px;
    border-radius: 8px;
    z-index: 1000;
    min-width: 500px;
    max-width: 500px;
    max-height: 300px;
    overflow-y: auto;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    text-align: left;
    display: none;

    scrollbar-width: none;
    /* Firefox */
    -ms-overflow-style: none;
    /* IE/Edge */
}

.tooltip-content::-webkit-scrollbar {
    display: none;
    /* Chrome/Safari */
}

.tooltip-content::after {
    content: '';
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    border-width: 8px;
    border-style: solid;
    border-color: #333 transparent transparent transparent;
}

.tooltip-container:hover .tooltip-content:not(.pinned) {
    display: block;
}

.tooltip-content.pinned {
    display: block !important;
}

.container-checkbox {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 13px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    font-weight: bold;
}

.checkmark-checkbox {
    position: absolute;
    top: 0;
    left: 0;
    height: 20px;
    width: 20px;
    background-color: #eee;
}

/******** Radio ******* */

.container-radio {
    display: block;
    position: relative;
    /*padding-left: 35px;*/
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 13px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    font-weight: bold;
}

.container-radio>input[type="radio"] {
    height: 17px;
    width: 17px;
}
</style>
