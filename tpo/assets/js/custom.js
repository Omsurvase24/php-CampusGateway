$(function () {
  // on page refresh
  const urlParams = new URLSearchParams(window.location.search);
  const pathName = window.location.pathname;
  const jobId = urlParams.get('jobId');
  if (jobId && pathName.includes('applications.php')) {
    fetchJobApplications(jobId);
  }
  if (jobId && pathName.includes('offers.php')) {
    fetchJobOffers(jobId);
  }

  $(document).on('click', '#deleteJob', function (e) {
    e.preventDefault();

    const jobId = $(this).val();

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
            jobId: jobId,
            deleteJob: true,
          },
          success: function (response) {
            const res = JSON.parse(response);

            if (res.status == 200) {
              swal('Success', res.message, 'success');
            } else {
              swal('Error', res.message, 'error');
            }

            $('#jobTable').load(location.href + ' #jobTable');
          },
        });
      }
    });
  });

  $(document).on('click', '#deleteCompany', function (e) {
    e.preventDefault();

    const companyId = $(this).val();

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
            companyId: companyId,
            deleteCompany: true,
          },
          success: function (response) {
            const res = JSON.parse(response);

            if (res.status == 200) {
              swal('Success', res.message, 'success');
            } else {
              swal('Error', res.message, 'error');
            }

            $('#companyTable').load(location.href + ' #companyTable');
          },
        });
      }
    });
  });

  // dynamically render applicants
  $(document).on('change', '#applicationJobId', function (e) {
    const jobId = $(this).val();

    const currentUrl = window.location.href.split('?')[0];
    const newUrl = currentUrl + '?jobId=' + jobId;
    window.history.pushState({ path: newUrl }, '', newUrl);

    fetchJobApplications(jobId);
  });
  // fetch job applications and populate
  function fetchJobApplications(jobId) {
    $.ajax({
      method: 'POST',
      url: 'actions.php',
      data: {
        jobId: jobId,
        getApplicants: true,
      },
      success: function (response) {
        const res = JSON.parse(response);

        if (res.status == 200) {
          const applicants = res.data;

          const tableContainer = $('#applicationsTable');

          if (applicants.length > 0) {
            const table = $('<table>').addClass(
              'min-w-full text-left text-sm font-light'
            );

            const tableHeader = $('<thead>')
              .addClass('border-b font-medium border-neutral-600')
              .append(
                $('<tr>').append(
                  $('<th>').addClass('px-6 py-4').text('ID'),
                  $('<th>').addClass('px-6 py-4').text('Name'),
                  $('<th>').addClass('px-6 py-4').text('Email'),
                  $('<th>').addClass('px-6 py-4').text('Contact No'),
                  $('<th>').addClass('px-6 py-4').text('Branch'),
                  $('<th>').addClass('px-6 py-4').text('Offer'),
                  $('<th>').addClass('px-6 py-4').text('Delete')
                )
              );

            const tableBody = $('<tbody>');

            $.each(applicants, function (index, applicant) {
              const row = $('<tr>').append(
                $('<td>')
                  .addClass('whitespace-nowrap px-6 py-4')
                  .text(applicant.applicationId),
                $('<td>')
                  .addClass('whitespace-nowrap px-6 py-4')
                  .text(applicant.name),
                $('<td>')
                  .addClass('whitespace-nowrap px-6 py-4')
                  .text(applicant.email),
                $('<td>')
                  .addClass('whitespace-nowrap px-6 py-4')
                  .text(applicant.contactNo),
                $('<td>')
                  .addClass('whitespace-nowrap px-6 py-4')
                  .text(applicant.branch),
                $('<td>')
                  .addClass('whitespace-nowrap px-6 py-4')
                  .append(
                    $('<button>')
                      .attr({
                        type: 'submit',
                        id: 'offerJob',
                        value: JSON.stringify({
                          jobId: jobId,
                          userId: applicant.userId,
                        }),
                      })
                      .addClass('fa-solid fa-envelope-circle-check')
                  ),
                $('<td>')
                  .addClass('whitespace-nowrap px-6 py-4')
                  .append($('<button>').text('Delete'))
              );
              tableBody.append(row);
            });

            table.append(tableHeader, tableBody);

            tableContainer.empty().append(table);
          } else {
            tableContainer
              .empty()
              .append(
                $('<p>')
                  .addClass('text-neutral-400 py-3')
                  .text('No record found')
              );
          }
        } else {
        }
      },
    });
  }
  $(document).on('click', '#offerJob', function () {
    const data = JSON.parse($(this).val());

    $.ajax({
      method: 'POST',
      url: 'actions.php',
      data: {
        jobId: data.jobId,
        userId: data.userId,
        offerJob: true,
      },
      success: function (response) {
        const res = JSON.parse(response);

        if (res.status == 200) {
          swal('Success', res.message, 'success');
        } else {
          swal('Error', res.message, 'error');
        }
      },
    });
  });

  // dynamically render offers
  $(document).on('change', '#offerJobId', function (e) {
    const jobId = $(this).val();

    const currentUrl = window.location.href.split('?')[0];
    const newUrl = currentUrl + '?jobId=' + jobId;
    window.history.pushState({ path: newUrl }, '', newUrl);

    fetchJobOffers(jobId);
  });
  // fetch job offers and populate
  function fetchJobOffers(jobId) {
    $.ajax({
      method: 'POST',
      url: 'actions.php',
      data: {
        jobId: jobId,
        getOffers: true,
      },
      success: function (response) {
        const res = JSON.parse(response);

        if (res.status == 200) {
          const applicants = res.data;

          const tableContainer = $('#offersTable');

          if (applicants.length > 0) {
            const table = $('<table>').addClass(
              'min-w-full text-left text-sm font-light'
            );

            const tableHeader = $('<thead>')
              .addClass('border-b font-medium border-neutral-600')
              .append(
                $('<tr>').append(
                  $('<th>').addClass('px-6 py-4').text('ID'),
                  $('<th>').addClass('px-6 py-4').text('Name'),
                  $('<th>').addClass('px-6 py-4').text('Email'),
                  $('<th>').addClass('px-6 py-4').text('Contact No'),
                  $('<th>').addClass('px-6 py-4').text('Branch'),
                  $('<th>').addClass('px-6 py-4').text('Package'),
                  $('<th>').addClass('px-6 py-4').text('Delete')
                )
              );

            const tableBody = $('<tbody>');

            $.each(applicants, function (index, applicant) {
              const row = $('<tr>').append(
                $('<td>')
                  .addClass('whitespace-nowrap px-6 py-4')
                  .text(applicant.userId),
                $('<td>')
                  .addClass('whitespace-nowrap px-6 py-4')
                  .text(applicant.name),
                $('<td>')
                  .addClass('whitespace-nowrap px-6 py-4')
                  .text(applicant.email),
                $('<td>')
                  .addClass('whitespace-nowrap px-6 py-4')
                  .text(applicant.contactNo),
                $('<td>')
                  .addClass('whitespace-nowrap px-6 py-4')
                  .text(applicant.branch),
                $('<td>')
                  .addClass('whitespace-nowrap px-6 py-4')
                  .text(`${applicant.package} LPA`),
                $('<td>')
                  .addClass('whitespace-nowrap px-6 py-4')
                  .append(
                    $('<button>')
                      .attr({
                        type: 'submit',
                        id: 'deleteOffer',
                        value: applicant.offerId,
                      })
                      .addClass('fa-solid fa-trash')
                  )
              );
              tableBody.append(row);
            });

            table.append(tableHeader, tableBody);

            tableContainer.empty().append(table);
          } else {
            tableContainer
              .empty()
              .append(
                $('<p>')
                  .addClass('text-neutral-400 py-3')
                  .text('No record found')
              );
          }
        } else {
        }
      },
    });
  }
  $(document).on('click', '#deleteOffer', function () {
    const offerId = $(this).val();

    $.ajax({
      method: 'POST',
      url: 'actions.php',
      data: {
        offerId: offerId,
        deleteOffer: true,
      },
      success: async function (response) {
        const res = JSON.parse(response);

        if (res.status == 200) {
          await fetchJobOffers(jobId);
          swal('Success', res.message, 'success');
        } else {
          swal('Error', res.message, 'error');
        }
      },
    });
  });
});
