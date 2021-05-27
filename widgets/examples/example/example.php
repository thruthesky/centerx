<?php
/**
 * @size wide
 */
?>
<h1>X.CSS Class Example</h1>
<p>
    x.css is loaded by all theme and is produced by x.scss.
</p>
<h3>.list-style-none & ul.ellipsis class</h3>
Note, `li` tag or its parent tag must have a limited with. It is better to use within bootstrap grid.
<hr>
<div class="row">
    <div class="col-6">
        <ul>
            <li>List Item1 - This structure is also found in classic</li>
            <li>List Item2</li>
            <li>List Item3 - religious and philosophical texts</li>
            <li>Robert A. Heinlein's later books (The Number of the Beast, The Cat Who Walks Through Walls and To Sail Beyond the Sunset) propose the idea that every real universe is a fiction in another universe. </li>
        </ul>
    </div>
    <div class="col-6">
        <ul class="list-style-none ellipsis bg-dark white">
            <li>List Item1 - This structure is also found in classic</li>
            <li>List Item2</li>
            <li>List Item3 - religious and philosophical texts</li>
            <li>
                <a href="#">Robert A. Heinlein's later books (The Number of the Beast, The Cat Who Walks Through Walls and To Sail Beyond the Sunset) propose the idea that every real universe is a fiction in another universe.</a>
            </li>
        </ul>
    </div>
</div>


<h3>.progress-bar</h3>

<div class="progress-bar">
    <div style="width: 50%">50%</div>
</div>

<hr>

<h1>Javascript common.js Example</h1>
<p>
    common.js is loaded by default on all theme.
</p>

<h3>Toast</h3>
<div class="btn btn-primary" onclick="toast('title', 'body')">Open a toast</div>
<div class="btn btn-primary" onclick="confirmToast()">Open a confirm toast. Yes or No</div>
<script>
    function confirmToast() {
        toast('A confirm toast', 'toast body', [{
            text: 'Yes',
            onclick: function() { alert('yes'); }
        }, {
            text: 'No',
            class: 'ml-3',
            onclick: function() { alert('no'); }
        }])
    }
</script>