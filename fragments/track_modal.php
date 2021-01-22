 <!-- Add Track modal -->
 <div id="add-track-modal" class="add-track-modal modal">
    <div class="add-track-content content">
        <span class="close-add-track-modal close">&times;</span>
        <div class="add-track-items">
            <div id="track" class="type">
            <h1>Add new Track</h1>
                <form method="POST" id="add-track-form" class="modal-form">
                        <input type="text" name="" id="add-track-name" placeholder="Name">
                        <input type="text" name="" id="add-track-album-id" placeholder="Album Id">
                    
                        <select id="add-track-genre-id" name="genre-id">
                            <option selected="true" disabled="disabled">Genre</option>
                        </select>
                        <select id="add-track-media-id" name="media-id">
                            <option selected="true" disabled="disabled">Media Type</option>
                        </select>
                        <input type="text" name="" id="add-track-composer" placeholder="Composer">
                        <input type="text" name="" id="add-track-time" placeholder="Milliseconds">
                        <input type="text" name="" id="add-track-bytes" placeholder="Bytes">
                        <input type="text" name="" id="add-track-price" placeholder="Unit Price">
                        <input type="submit" value="Add">

                </form>
            </div>
        </div>
    </div>
</div>
 <!--  read track modal -->
 <div id="read-track-modal" class="read-track-modal modal">
        <div class="track-content content">
            <span class="close-read-track-modal close">&times;</span>
            <div class="track-items">
                
                <h3>Track: <span id="read-title"></span></h3>
                <p> <b>Artist:</b> <span id="read-artist"></span></p>
                <p> <b>Album:</b> <span id="read-album"></span></p>
                <p> <b>Composer:</b> <span id="read-composer"></span></p>
                <p> <b>Genre:</b> <span id="read-genre"></span></p>    
            </div>
        </div>
</div>

<!--  update track modal -->
<div id="update-track-modal" class="update-track-modal modal">
    <div class="update-track-content content">
        <span class="close-update-track-modal close">&times;</span>
        <div class="track-items">
            <h1>track</h1>
            <form method="post" id="update-track-form" class="modal-form">
                <input type="hidden" name="id" id="update-track-id">
                <label for="title">Track</label>
                <input type="text" id="update-track-name" name="title">
                <label for="album-id">Album</label>
                <input type="text" id="update-track-album-id" name="album-id">
                <label for="media-id">MediaType</label>
                <select id="update-media-id" name="media-id"></select>
                <label for="genre-id">Genre</label>
                <select id="update-genre-id" name="genre-id"></select>
                <label for="time">Composer</label>
                <input type="text" id="update-composer" name="time">
                <label for="time">Milliseconds</label>
                <input type="text" id="update-time" name="time">
                <label for="bytes">Bytes</label>
                <input type="text" id="update-bytes" name="bytes">
                <label for="price">Price</label>
                <input type="text" id="update-price" name="price">
                <input type="submit" value="Update">
            </form>
            
                    
        </div>
    </div>
</div>