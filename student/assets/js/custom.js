$(function () {
  $(document).on('click', '#deleteApplication', function (e) {
    e.preventDefault();

    const applicationId = $(this).val();

    swal({
      title: 'Are you sure?',
      text: 'Once deleted, you will not be able to recover!',
      icon: 'warning',
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $.ajax({
          method: 'POST',
          url: 'actions.php',
          data: {
            applicationId: applicationId,
            deleteApplication: true,
          },
          success: function (response) {
            console.log(response);
            const res = JSON.parse(response);

            if (res.status == 200) {
              swal('Success', res.message, 'success');
            } else {
              swal('Error', res.message, 'error');
            }

            $('#appliedTable').load(location.href + ' #appliedTable');
          },
        });
      }
    });
  });
});
