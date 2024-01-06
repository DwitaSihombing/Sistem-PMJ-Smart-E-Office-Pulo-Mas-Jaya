<x-auth title="E Office | Edit Jabatan">
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Detail Data Jabatan</h4>
            </div>
        </div>
    </div>
    <!-- /Page Title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="text" class="field" name="name" value="{{ $job->jobLevel->name }}" readonly disabled>
                                @error('job_level')
                                    <p class="invalid">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 col-md-6 mb-3">
                                <input type="text" class="field" name="name" value="{{ $job->parent->name ?? ''  }}" readonly disabled>
                            </div>
                            <div class="col-12 mb-3">
                                <input type="text" class="field" name="name" value="{{ $job->name }}" readonly disabled>
                                @error('name')
                                    <p class="invalid">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var $jobLevelField = $("select[name='job_level']");

            if($jobLevelField.val()) {
                $.getJSON(`/ajax/job-levels/${$jobLevelField.val()}/parent/jobs`, function(response) {
                    $jobField = $("select[name='job_id']");
                    $jobField.html('');

                    if(Object.keys(response).length > 0) {
                        $jobField.append($('<option>', {
                            text: `Pilih ${response.name}`,
                            selected: true,
                            disabled: true,
                        }));

                        if(response.jobs) {
                            response.jobs.forEach(function(job) {
                                $jobField.append($('<option>', {
                                    value: job.id,
                                    text: job.name,
                                    selected: job.id == $jobField.data('selected'),
                                }));
                            });
                        }
                    }

                    $jobField.prop('disabled', false);
                });
            }

            $("select[name='job_level']").change(function(e) {
                var id = e.target.value;

                $.getJSON(`/ajax/job-levels/${id}/parent/jobs`, function(response) {
                    $jobField = $("select[name='job_id']");
                    $jobField.html('');

                    if(Object.keys(response).length > 0) {
                        $jobField.append($('<option>', {
                            text: `Pilih ${response.name}`,
                            selected: true,
                            disabled: true,
                        }));

                        if(response.jobs) {
                            response.jobs.forEach(function(job) {
                                $jobField.append($('<option>', {
                                    value: job.id,
                                    text: job.name,
                                }));
                            });
                        }
                    }

                    $jobField.prop('disabled', false);
                });
            });
        })
    </script>
</x-auth>
