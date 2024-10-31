
$(function () {

    let uploadedImages = {};
    let imagesLinksStart = [];
    let imagesLinksFinal = [];

    // summernote init
    $('#postContent').summernote({
        placeholder: 'Hello stand alone ui',
        tabsize: 2,
        height: 500,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['codeview', 'help']]
        ],
        callbacks: {
            onImageUpload: function (files) {

                 let imageIndex = 'img_' + Date.now();

                 uploadedImages[imageIndex] = files[0];

                //decode file in Base64 and insert to text including file name as data-name attribute
                const reader = new FileReader();/**/
                reader.onload = function (e) {

                    $('#postContent').summernote('insertImage', e.target.result, function ($image) {
                        //$image.attr('data-filename', files[0].name);
                        $image.attr('data-index', imageIndex);
                    });

                    console.log(uploadedImages);
                }
                reader.readAsDataURL(files[0]);
            },

            onInit: function (){

                let imagesWithLinksStart = getImages(true);
                //console.log(imagesWithLinksStart);

                imagesLinksStart = createImagesLinksArray(imagesWithLinksStart);
                console.log(imagesLinksStart);

                /*if(imagesLinksStart.count > 0){

                    let earlyDeletedImagesLinks = getLinksFromCookies();

                    removeDeletedImagesLinks(imagesWithLinksStart, earlyDeletedImagesLinks);

                }*/



            },

        }

    });



    $('form').on('submit', async function (e) {

        e.preventDefault();

        console.log(uploadedImages);

        if (Object.keys(uploadedImages).length > 0) {

            let dataImages = getImages();

            //console.log(dataImages);

            let dataImagesIndexes = createImagesIndexesArray(dataImages);

            console.log(dataImagesIndexes);

            let uploadedImagesForSave = filterImagesFiles(uploadedImages, dataImagesIndexes);

            console.log(uploadedImagesForSave);

            if (Object.keys(uploadedImagesForSave).length > 0) {

                let newImagesUrls = await saveImages(uploadedImagesForSave);

                console.log(newImagesUrls);

                if(!newImagesUrls){
                    return;
                }

                insertImagesUrls(dataImages, newImagesUrls);
            }
            console.log('Finish!');
        }


        if(imagesLinksStart.length > 0){

            let imagesWithLinksFinal = getImages(true);
            console.log(imagesWithLinksFinal);

            imagesLinksFinal = createImagesLinksArray(imagesWithLinksFinal);
            console.log(imagesLinksFinal);

            let imagesLinksToDelete = createImagesLinksToDeleteArray(imagesLinksStart, imagesLinksFinal);
            console.log(imagesLinksToDelete);

            if(imagesLinksToDelete.length > 0) {

                console.log('Im here!!');

                let result = await deleteImages(imagesLinksToDelete).catch((e) => {
                    throw new Error(e.responseText);
                });

                console.log(result);

                if(!result.success){
                    alert('Ne všechny obrázky byly úspěšně odstraněny ze serveru. Nahlaste na podporu.\n')
                }else{
                    setLinksInCookies(imagesLinksToDelete);
                }

            }

        }

        const editorContent = $('#postContent').summernote('code');
        $('#postContent').summernote('code', editorContent);
        this.submit();

    });



    function getImages(links = false){
        if (links){
            return $('#postContent').next('div').find('img').not("[src*='data:image']");
        }else {
            return $('#postContent').next('div').find("img[src*='data:image']");
        }
    }


    function filterImagesFiles(uploadedImages, imagesIndexes) {
        for (let key in uploadedImages) {

            if(!imagesIndexes.includes(key)){

                delete uploadedImages[key];

            }
        }
        return uploadedImages;
    }

    function createImagesIndexesArray(images) {
        let imagesIndexes = [];
        Object.values(images).forEach(function (file) {
            let $file = $(file);
            let imageIndex = $file.attr('data-index');
            if (imageIndex) {
                imagesIndexes.push(imageIndex);
            }

        })
        return imagesIndexes;
    }



    function createImagesLinksArray(images) {

        let imagesLinks = [];
        Object.values(images).forEach(function (file) {
            if(file instanceof HTMLImageElement){
                let $file = $(file);
                let imageLink = $file.attr('src');
                if(imageLink){
                    imagesLinks.push(imageLink);
                }

            }


        })
        return imagesLinks;

    }

    function createImagesLinksToDeleteArray(imagesLinksStart, imagesLinksFinal){
        let imagesLinksToDelete = [];
        imagesLinksStart.forEach(function (value){
            if(!imagesLinksFinal.includes(value)){
                imagesLinksToDelete.push(value);
            }
        })
        return imagesLinksToDelete;
    }

    function getCSRFToken(){
        return $("input[name=token]").val() ?? null;
    }

    function insertImagesUrls(images, imagesUrls){
        Object.values(images).forEach(function (file) {
            if(file instanceof HTMLImageElement){

                let $file = $(file);
                let imageIndex = $file.data('index');
                $file.attr('src', imagesUrls[imageIndex]);
            }
        })
    }

     function saveImages(images){
         return new Promise((resolve,reject)=> {

             let data = new FormData;
             for (const key in images) {
                 if (images.hasOwnProperty(key)) {
                     data.append(key, images[key]);
                 }
             }

             let token = getCSRFToken();

             console.log(token);

             data.append('token', token);

             $.ajax({
                 url: 'admin/posts/save-image',
                 method: 'POST',
                 data: data,
                 processData: false,
                 contentType: false
             })
             .done((response) => {

                 console.log(response);

                 if(response.error){
                     console.log(response.error);
                     resolve(false);
                 }
                 resolve(JSON.parse(response));
             })


             .fail(() => {
                 console.log('Save image error.');
                 resolve(false);

             })
        })
    }


    function deleteImages(imagesLinks){
        return new Promise((resolve,reject)=> {


            let links = imagesLinks;

            let token = getCSRFToken();


            $.ajax({
                url: 'admin/posts/delete-images',
                method: 'POST',
                data: {links, token},
                dataType: 'json'
            })
                .done((response) => {
                    console.log(response);
                    resolve(response);
                })


                .fail((response) => {
                    console.log('Delete images error.');
                    reject(response);

                })
        })

    }

    function setLinksInCookies(links) {
        const expiryDate = new Date();
        expiryDate.setDate(expiryDate.getDate() + 2); // Куки на 2 дня
        document.cookie = `deletedLinks=${JSON.stringify(links)}; expires=${expiryDate.toUTCString()}; path=/`;
    }


    function getLinksFromCookies() {
        const cookie = document.cookie
            .split('; ')
            .find(row => row.startsWith('deletedLinks='));
        return cookie ? JSON.parse(cookie.split('=')[1]) : [];
    }


    function removeDeletedImagesLinks(linksFromContent, deletedLinks){

        linksFromContent.forEach(function (value){

            if(deletedLinks.includes(value)){

                $('#postContent').next('div').find("img[src='" + value + "']");

            }
        })

    }

})