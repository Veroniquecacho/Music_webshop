 <!-- Add Album modal -->
<div id="add-album-modal" class="add-album-modal modal">
    <div class="add-album-content content">
        <span class="close-add-album-modal close">&times;</span>
        <div class="add-album-items">
            <div id="album" class="type" >
                <h1>Add new Album</h1>
                <form method="POST" id="add-album-form" class="modal-form">
                        <input type="text" name="" id="add-album-title" placeholder="Title">
                        <input type="text" name="" id="add-album-artist-id" placeholder="Artist Id">
                        <input type="submit" value="Add">
                </form>
            </div>

        </div>
    </div>
</div>
 <!-- Read Album modal -->
<div id="read-album-modal" class="read-album-modal modal">
    <div class="album-content content">
        <span class="close-album-modal close">&times;</span>
        <div class="album-items">
            <h1>Album</h1>
            <p>Album: <span id="read-album-title"></span></p>
            <p>Artist: <span id="read-album-artist"></span></p>
           
            
        </div>
    </div>
</div>

<!-- Update album modal -->
<div id="update-album-modal" class="update-album-modal modal">
    <div class="update-album-content content">
        <span class="close-update-album-modal close">&times;</span>
        <div class="album-items">
            <h1>album</h1>
            <form method="post" id="update-album-form" class="modal-form">
                <input type="hidden" name="id" id="update-album-id">
                <label for="album-id">Album</label>
                <input type="text" id="update-album-title" name="update-album-title">
                <label for="artist-id">Artist</label>
                <input type="text" id="update-album-artist-id" name="update-album-artist-id" >
                
                <input type="submit" value="Update">
            </form>
            
                    
        </div>
    </div>
</div>