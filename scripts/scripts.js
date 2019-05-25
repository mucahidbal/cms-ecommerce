function addItem() {
    function checkInputs() {
        return document.getElementById("coverPhotoInput").files.length > 0 &&
        document.getElementById("name").value !== "" &&
        document.getElementById("category").value !== "" &&
        document.getElementById("price").value !== "" &&
        document.getElementById("description").value !== "";
    }

    if (checkInputs()) {
        let json_obj = {"name": encodeURIComponent(document.getElementById("name").value),
            "price": encodeURIComponent(document.getElementById("price").value),
            "description": encodeURIComponent(document.getElementById("description").value)};

        let category_selector = document.getElementById("category");
        let selected_category_id = category_selector.options[category_selector.selectedIndex].value;
        json_obj.category = encodeURIComponent(selected_category_id);

        let xhttp = new XMLHttpRequest();

        xhttp.open("POST", "../api/add-item.php", false);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("json_data=" + JSON.stringify(json_obj));
        let response = JSON.parse(xhttp.responseText);

        uploadImage(response.pid);
    } else {
        alert("Lütfen eksik alanları doldurun.");
    }
}

function deleteItem(pid) {
    let json_obj = {"pid": pid};
    let xhttp = new XMLHttpRequest();
    xhttp.open("POST", "../api/delete-item.php", false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("json_data=" + JSON.stringify(json_obj));

    location.reload();
}

function uploadImage(pid) {
    // Access the form element
    let form = document.getElementById("upload-form");

    let XHR = new XMLHttpRequest();

    // Bind the FormData object and the form element
    let FD = new FormData(form);

    FD.append("pid", pid);

    // Set up our request
    XHR.open("POST", "../api/upload.php", false);

    // The data sent is what the user provided in the form
    XHR.send(FD);

    // // Define what happens on successful data submission
    // XHR.addEventListener("load", function(event) {
    //     alert(event.target.responseText);
    // });
    //
    // // Define what happens in case of error
    // XHR.addEventListener("error", function(event) {
    //     alert('Oops! Something went wrong.');
    // });
}

function showThumbnails(files, listID) {
    window.URL = window.URL || window.webkitURL;

    const fileList = document.getElementById(listID);

    if (!files.length) {
        fileList.innerHTML = "<p>No files selected!</p>";
    } else {
        fileList.innerHTML = "";
        const list = document.createElement("ul");
        fileList.appendChild(list);
        for (let i = 0; i < files.length; i++) {
            const li = document.createElement("li");
            li.style = "list-style: none";
            list.appendChild(li);

            const img = document.createElement("img");
            img.src = window.URL.createObjectURL(files[i]);
            img.height = 60;
            img.onload = function() {
                window.URL.revokeObjectURL(this.src);
            };
            li.appendChild(img);
            // const info = document.createElement("span");
            // info.innerHTML = files[i].name + ": " + files[i].size + " bytes";
            // li.appendChild(info);
        }
    }
}

function addCategory() {
    function checkInputs() {
        return document.getElementById("category-name").value !== "";
    }

    if (checkInputs()) {
        let json_obj = {"category-name": encodeURIComponent(document.getElementById("category-name").value)};
        let xhttp = new XMLHttpRequest();

        xhttp.open("POST", "../api/add-category.php", false);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("json_data=" + JSON.stringify(json_obj));
        // let response = JSON.parse(xhttp.responseText);
        location.reload();
    } else {
        alert("Lütfen Kategori ismi girin");
    }
}

function deleteCategory(pid) {
    let json_obj = {"pid": pid};
    let xhttp = new XMLHttpRequest();
    xhttp.open("POST", "../api/delete-category.php", false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("json_data=" + JSON.stringify(json_obj));

    location.reload();
}