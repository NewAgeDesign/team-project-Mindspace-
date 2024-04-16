<?php 
include "header.php";

?>
<?php 
if (isset($_SESSION['id'])){
    echo '
    <main class="dashboard">
        <div class="chats">
            <div class="title">
                <b>Chats</b>
                <div class="search">
                    <input type="text" placeholder="Search" id="search-input">
                </div>
            </div>
            <div class="chat">
            </div>
        </div>
        <div class="posts">
        </div>
        </div>
        <div class="profile">
            <div class="info">
                <img src="'.$_SESSION['avatar'].'" alt="'.$_SESSION["username"].'">
                <div class="image">+</div>
                <b>'.words($_SESSION["name"],3).'</b>
                <div class="status"><p class="sname">'.$_SESSION["username"].'</p><div class="role">'.$_SESSION["role edit-role"].'</div> <div class="role edit-profile">Edit</div></div>
            </div>
        </div>
    </main>
    ';
}
else{
    switch (isset($_GET)){
    case (isset($_GET['reg']) && $_GET['reg'] == 'signup' || empty($_GET)):
        echo '
        <main class="registry">
            <span class="left">
            '?><?php
            
                if (isset($_GET['err']) && $_GET['err'] == 'sbe1'){
                    echo '<div id="msg" class="bad">Empty fields, Please fill in all fields</div>';
                }
                elseif (isset($_GET['err']) && $_GET['err'] == 'sbe2'){
                    echo '<div id="msg" class="bad">Invalid email, Please input a valid email format</div>';
                }
                elseif(isset($_GET['err']) && $_GET['err'] == 'sbe3'){
                    echo '<div id="msg" class="bad">Password must be at least 8 characters long, Contain Capital Letters, numbers and symbols</div>';
                }
                elseif(isset($_GET['err']) && $_GET['err'] == 'sbe4'){
                    echo '<div id="msg" class="bad">Username must be at least 6 characters long</div>';
                }
                elseif(isset($_GET['err']) && $_GET['err'] == 'sbe5'){
                    echo '<div id="msg" class="bad">Invalid name, Your name can only contain letters</div>';
                }
                else{
                    echo'';
                }?><?php
            echo '
                <h2>Welcome to Mindspace</h2>
                <p>Your first step to having a fruitful mental health journey.</p>
            </span>
            <span class=right>
                <form action="header.php" method="post" id="create-account">
                    <h4>Sign up</h4>
                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>
                        <input type="text" name="email" class="form-control" id="email">
                    </div>
                    <div class="form-group">
                        <label for="psw" class="control-label">Password</label>
                        <input type="password" name="psw" class="form-control" id="name">
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Full Name</label>
                        <input type="text" name="name" class="form-control" id="name">
                    </div>
                    <div class="form-group">
                    <label for="alias" class="control-label">Username</label>
                    <input type="alias" name="alias" class="form-control" id="alias">
                    </div>
                    <div class=row>
                        <button type="submit" class="btn" name="signup">Sign up</button>
                        <a href="index.php?reg=login">Already have an account?</a>
                    </div>
                </form>
            </span>
        </main>
        ';
        break;
    case (isset($_GET['reg']) && $_GET['reg'] == 'login'):
        echo '
        <main class="registry">
            <span class="left">
            '?><?php
                if (isset($_GET['err']) && $_GET['err'] == 'lbe1'){
                    echo '<div id="msg" class="bad">Empty fields, Please fill in all fields</div>';
                }
                elseif(isset($_GET['err']) && $_GET['err'] == 'lbe2'){
                    echo '<div id="msg" class="bad">User doesn\'t exist, please enter an existing username or email</div>';
                }
                elseif(isset($_GET['err']) && $_GET['err'] == 'lbe3'){
                    echo '<div id="msg" class="bad">Incorrect password, if you\'ve forgotten your password, please try a password reset.</div>';
                }
                elseif (isset($_GET['err']) && $_GET['err'] == 'sge'){
                    echo '<div id="msg" class="good">You\'ve successfully registered your account, please login</div>';
                }
                elseif (isset($_GET['err']) && $_GET['err'] == 'rpge'){
                    echo '<div id="msg" class="good">You\'ve successfully reset your password, please login</div>';
                }
                elseif(isset($_GET['err']) && $_GET['err'] == 'loge'){
                    echo '<div id="msg" class="good">You\'ve successfully logged out, we hope to see you back soon</div>';
                }
                else{
                    echo'';
                }
                
                ?><?php
            echo '
                <h2>Welcome Back</h2>
                <p>Let\'s see you inside. Please login to your account </p>
            </span>
            <span class=right>
                <form action="header.php" method="post" id="login">
                    <h4>Login</h4>
                    <div class="form-group">
                        <label for="user" class="control-label">Username | email</label>
                        <input type="text" name="alias" class="form-control" id="user">
                    </div>
                    <div class="form-group>
                        <label for="psw" class="control-label">Password</label>
                        <input type="password" name="psw" class="form-control" id="psw">
                    </div>
                    <div class=row>
                        <button type="submit" class="btn" name="login">Login</button>
                        <a href="index.php?reg=signup">Create an account</a>
                        <a href="index.php?reg=reset">Forgot Password</a>
                    </div>
                </form>
            </span>
        </main>
        ';
        break;
    case (isset($_GET['reg']) && $_GET['reg'] == 'reset'):
        echo '
        <main class="registry">
            <span class="left">
            '?><?php

                if (isset($_GET['err']) && $_GET['err'] == 'rbe1'){
                    echo '<div id="msg" class="bad">Empty fields, Please fill in all fields</div>';
                }
                elseif(isset($_GET['err']) && $_GET['err'] == 'rbe2'){
                    echo '<div id="msg" class="bad">Invalid Email, please input the correct email format</div>';
                }
                elseif(isset($_GET['err']) && $_GET['err'] == 'rbe3'){
                    echo '<div id="msg" class="bad">User doesn\'t exist, please enter an existing username or email</div>';
                }
                elseif(isset($_GET['err']) && $_GET['err'] == 'rbe4'){
                    echo '<div id="msg" class="bad">Query Error</div>';
                }
                elseif(isset($_GET['err']) && $_GET['err'] == 'rbe5'){
                    echo '<div id="msg" class="bad">Query Error 2</div>';
                }
                elseif(isset($_GET['err']) && $_GET['err'] == 'rge'){
                    echo '<div id="msg" class="good">We\'ve sent you a verification email, please follow the instructions and reset your password.</div>';
                }
                else{
                    echo'';
                }?><?php
            echo '       
                <h2>Let us help you out</h2>
                <p>Don\'t worry, happens all the time, please enter your username. Or Email</p>
            </span>
            <span class=right>
                <form action="header.php" method="post" id="forgot">
                    <h4>Forgot Password</h4>
                    <div class="form-group>
                        <label for="email" class="control-label">Email</label>
                        <input type="text" name="email" class="form-control" id="email">
                    </div>
                    <div class=row>
                        <button type="submit" class="btn" name="reset">Reset</button>
                        <a href="index.php?reg=login">Login</a>
                    </div>
                </form>
            </span>
        </main>';
        break;
    case (isset($_GET['reg']) && $_GET['reg'] == 'resetpsw'):
        echo '
        <main class="registry">
            <span class="left">  
            
            '?><?php
                if (isset($_GET['err']) && $_GET['err'] == 'rpbe1'){
                    echo '<div id="msg" class="bad">Empty fields, Please fill in all fields</div>';
                }
                elseif(isset($_GET['err']) && $_GET['err'] == 'rpbe2'){
                    echo '<div id="msg" class="bad">Invalid Password, Password must be at least 8 characters long, Contain Capital Letters, numbers and symbols</div>';
                }
                elseif(isset($_GET['err']) && $_GET['err'] == 'rpbe3'){
                    echo '<div id="msg" class="bad">Query Error</div>';
                }
                elseif(isset($_GET['err']) && $_GET['err'] == 'rpbe4'){
                    echo '<div id="msg" class="bad">Query Error 2</div>';
                }
                elseif(isset($_GET['err']) && $_GET['err'] == 'rpbe5'){
                    echo '<div id="msg" class="bad">Invalid token, please check your email</div>';
                }
                elseif(isset($_GET['err']) && $_GET['err'] == 'rpbe6'){
                    echo '<div id="msg" class="bad">Query Error 3</div>';
                }
                elseif(isset($_GET['err']) && $_GET['err'] == 'rpbe7'){
                    echo '<div id="msg" class="bad">Query Error 4</div>';
                }
                elseif(isset($_GET['err']) && $_GET['err'] == 'rpbe8'){
                    echo '<div id="msg" class="bad">Query Error 5</div>';
                }
                elseif(isset($_GET['err']) && $_GET['err'] == 'rpbe9'){
                    echo '<div id="msg" class="bad">Query Error 6</div>';
                }

                else{
                    echo'';
                }?><?php
            echo '     
                <h2>We Never Doubted You</h2>
                <p>We\'ve Confirmed your account, please change your email and we\'ll see you inside.</p>
            </span>
            <span class=right>
                <form action="header.php" method="post" id="resetpsw">
                <h4>Reset Password</h4>'?><?php
                $selector = $_GET['sel'];
                $validator = $_GET['val'];
                if (empty($selector) || empty($validator)){
                    echo "We could not validate your request";
                } else {
                    if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false){
                        $selector = htmlspecialchars($selector);
                        $validator = htmlspecialchars($validator);
                        echo '
                            <input type="hidden" name="selector" value="'.$selector.'">
                            <input type="hidden" name="validator" value="'.$validator.'">
                            <div class="form-group>
                                <label for="psw" class="control-label">New Password</label>
                                <input type="password" name="psw" class="form-control" id="psw">
                            </div>
                            <div class="row">
                                <button type="submit" class="btn" name="resetpsw">Reset</button>
                                <a href="index.php?reg=login">Login</a>
                            </div>
                        </form>
                    </span>
                    ';
                } 
            }
        break;
    }
}

?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    fetch('ajaxuser.php')
        .then(response => response.json())
        .then(users => {

            var chatBox = document.querySelector('.chat'); // replace with the actual selector of your chat box
            chatBox.innerHTML = ''; // clear the chat box
            users.forEach(user => {
                var person = document.createElement('div');
                person.className = 'person';
                person.id = user.id;
                person.setAttribute('data-name', user.name);
                person.innerHTML = `
                    <img src="${user.avatar}" alt="${user.name}">
                    <div class="details">
                        <b>${user.name}</b>
                        <p></p>
                    </div>
                `;
                chatBox.appendChild(person);
            });
    });
        
    fetch('ajaxuser.php')
    .then(response => response.json())
    .then(users => {
        var chatBox = document.querySelector('.chat');
        chatBox.innerHTML = '';
        users.forEach(user => {
            var person = document.createElement('div');
            person.className = 'person';
            person.id = user.id;
            person.setAttribute('data-name', user.name);
            person.innerHTML = `
                <img src="${user.avatar}" alt="${user.name}">
                <div class="details">
                    <b>${user.name}</b>
                    <p>${user.message}</p>
                </div>
            `;
            chatBox.appendChild(person);
        });
    });

    fetch('ajaxuser.php')
    .then(response => response.json())
    .then(users => {
        users.forEach(user => {
            var element = document.getElementById(user.id);
            if (element) {
                element.addEventListener("click", function() {
                    console.log(user.id);
                    localStorage.setItem('lastClickedUserId', user.id); // Store the clicked user ID in local storage
                    displayChatInterface(user);
                    text(user.id); // Call text() with the receiver's ID
                });
            } else {
                document.querySelector(".posts").innerHTML = "<p class='no-user'>Select a user to chat</p>";
            }
        });

        // Check if there's a user ID in local storage
        var lastClickedUserId = localStorage.getItem('lastClickedUserId');
        if (lastClickedUserId) {
            // If there is, find that user and display the chat interface for them
            var user = users.find(user => user.id === lastClickedUserId);
            if (user) {
                displayChatInterface(user);
                text(user.id);
            }
        }
    });

});

function displayChatInterface(user) {
    document.querySelector(".posts").innerHTML = `
        <div class="top-bar">
            <div class="person">
                <img src="${user.avatar}" alt="${user.name}">
                <div class="details">
                <b>${user.name}</b>
                <p>Online</p>
            </div>
        </div>
        <div class="post">
            
        </div>
        <div class="post-actions">
            <form method="post" action="header.php" class="chat-form">
                <div class="chat-input">
                    <input type="text" placeholder="chat" name="message">
                    <input type="hidden" name="receiver" value="${user.id}">
                </div>
                <button type="submit" name="chat">></button>
            </form>
        </div>
    `;
}
function text(receiverId) {
    var sessionId = Number(<?php echo json_encode($_SESSION['id']); ?>); // Convert sessionId to a number

    fetch('ajaxmsg.php?id=' + receiverId) // Pass the receiver's ID
        .then(response => {
            if (!response.ok) {
                throw new Error("HTTP error " + response.status);
            }
            return response.json();
        })
        .then(messages => {
            var msgBox = document.querySelector('.post');
            msgBox.innerHTML = ''; // Clear the message box
            messages.forEach(message => {
                if (Number(message.sender_id) === sessionId){ // Convert message.sender_id to a number before comparing
                    console.log('sender_id:', message.sender_id, 'sessionId:', sessionId);
                    msgBox.innerHTML += `
                        <p class="me">
                            ${message.message}
                        </p>
                    `;
                }
                else{
                    console.log('sender_id:', message.sender_id, 'sessionId:', sessionId);
                    msgBox.innerHTML += `
                        <p class="you">
                            ${message.message}
                        </p>
                    `;
                }
            });
        })
        .catch(function(error) {
            console.log("Fetch error: ", error);
        });
}

document.querySelector('#search-input').addEventListener('input', function() {
    var searchTerm = this.value.toLowerCase();
    var found = false;
    document.querySelectorAll('.person').forEach(function(person) {
        var name = person.getAttribute('data-name').toLowerCase();
        if (name.includes(searchTerm)) {
            person.style.display = 'flex';
            found = true;
        } else {
            person.style.display = 'none';
        }
    });
    var chatBox = document.querySelector('.chat'); // replace with the actual selector of your chat box
    var noUserMessage = chatBox.querySelector('.no-user');
    if (!found) {
        if (!noUserMessage) {
            noUserMessage = document.createElement('p');
            noUserMessage.className = 'no-user';
            chatBox.appendChild(noUserMessage);
        }
        noUserMessage.textContent = 'No user goes by that name.';
    } else if (noUserMessage) {
        noUserMessage.remove();
    }
});
//Generate code for image upload, should only accept jpg, jpeg, and png files, should appear as a modal, should be able to close the modal

//Generate code for image upload, should only accept jpg, jpeg, and png files, should appear as a modal, should be able to close the modal

document.querySelector('.image').addEventListener('click', function() {
    var modal = document.createElement('div');
    modal.className = 'modal';
    modal.innerHTML = `
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="drop-zone">
                <p>Drag and drop a file OR <label for="file">click here</label></p>
                <input type="file" name="file" id="file" accept="image/jpeg, image/png">
            </div>
            <div id="crop-zone">
                <img id="image">
            </div>
            <button id="upload">Upload</button>
        </div>
    `;
    document.body.appendChild(modal);

    var modalContent = modal.querySelector('.modal-content');
    var dropZone = modal.querySelector('#drop-zone');
    var fileInput = modal.querySelector('#file');
    var cropZone = modal.querySelector('#crop-zone');
    var imageElement = modal.querySelector('#image');
    var uploadButton = modal.querySelector('#upload');
    var cropper;

    modal.querySelector('.close').addEventListener('click', function() {
        modal.remove();
    });

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.remove();
        }
    }

    dropZone.ondrop = function(e) {
        e.preventDefault();
        this.className = 'upload-drop-zone';

        var file = e.dataTransfer.files[0];
        startCrop(file);
    }

    dropZone.ondragover = function() {
        this.className = 'upload-drop-zone drop';
        return false;
    }

    dropZone.ondragleave = function() {
        this.className = 'upload-drop-zone';
        return false;
    }

    fileInput.onchange = function(e) {
        var file = e.target.files[0];
        startCrop(file);
    }

    function startCrop(file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            imageElement.src = e.target.result;
            dropZone.style.display = 'none';
            cropZone.style.display = 'block';
            cropper = new Cropper(imageElement, {
                aspectRatio: 1,
            });
        }
        reader.readAsDataURL(file);
    }

    uploadButton.onclick = function() {
        var canvas = cropper.getCroppedCanvas({
            width: 200,
            height: 200,
        });
        canvas.toBlob(function(blob) {
            if (blob === null) {
                alert('Please select an image to upload.');
                return;
            }

            var formData = new FormData();
            // Specify the filename and extension
            formData.append('croppedImage', blob, 'image.jpg');

            fetch('upload.php', {
                method: 'POST',
                body: formData
            })
            .then(() => {
                modal.remove();
                alert('Image uploaded successfully.');

            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    }
});
</script>
<?php
include "footer.php";
?>