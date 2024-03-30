<script>
  const container = document.querySelector('.ckeditor-container');
  container.style.display = 'none';
</script>
<script src="ckeditor/build/ckeditor.js"></script>
<script>
  ClassicEditor
    .create(document.querySelector('#editor'), {

      ckfinder:
      {
        uploadUrl: './fileupload.php'
      },
      image: {
        resizeUnit: "%",
        resizeOptions: [{
          name: 'resizeImage:original',
          value: null
        },
        {
          name: 'resizeImage:50',
          value: '50'
        },
        {
          name: 'resizeImage:75',
          value: '75'
        }],
        toolbar: ['resizeImage', 'imageStyle:inline', 'imageStyle:wrapText', 'imageStyle:breakText', '|',
          'toggleImageCaption', 'imageTextAlternative'],
      }
    })
    .then(editor => {
      console.log('Editor was initialized', editor);
      container.style.display = 'block';
    })
    .catch(error => {
      console.error('Error during initialization', error);
    });
</script>