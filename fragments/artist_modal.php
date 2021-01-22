  <!-- Add Artist modal -->
<div id="add-artist-modal" class="add-artist-modal modal">
    <div class="add-artist-content content">
        <span class="close-add-artist-modal close">&times;</span>
        <div class="add-artist-items">
            <div  class="type" >
                <h1>Add new Artist</h1>
                <form method="POST" id="add-artist-form" class="modal-form">
                        <input type="text" name="" id="add-artist-name" placeholder="Name">
                        <input type="submit" value="Add">
                </form>
            </div>
          
            
        </div>
    </div>
</div>
 
 <!-- Read Artist modal -->
<div id="read-artist-modal" class="read-artist-modal modal">
    <div class="artist-content content">
        <span class="close-read-artist-modal close">&times;</span>
        <div class="artist-items">
            <h1>Artist</h1>
            
            <p>Artist: <span id="read-artist-name"></span></p>
                
        </div>
    </div>
</div>

<!-- Update artist modal -->
<div id="update-artist-modal" class="update-artist-modal modal">
    <div class="update-artist-content content">
        <span class="close-update-artist-modal close">&times;</span>
        <div class="artist-items">
            <h1>artist</h1>
            <form method="post" id="update-artist-form" class="modal-form">
                <input type="hidden" name="id" id="update-artist-id">
                <label for="artist-id">Artist</label>
                <input type="text" id="update-artist-name" name="update-artist-name">
                <input type="submit" value="Update">
            </form>     
        </div>
    </div>
</div>