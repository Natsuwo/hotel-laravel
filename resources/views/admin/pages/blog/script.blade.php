<script>
    new FroalaEditor('textarea#content', {
        height: 300
    })

    $(document).ready(function() {
        $('#title').on('input', function() {
            $.ajax({
                url: '{{ route('admin.blog.slug') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    title: $(this).val()
                },
                success: function(res) {
                    $('#slug').val(res.slug)
                }
            })
        })
    })

    function chooseFile() {
        // clear previewContainer
        const previewContainer = $('#image_preview_container');
        previewContainer.html('');
        gallerySelected.forEach((image) => {
            if (!image.id) return;
            var input = $('<input>').attr('type', 'hidden').attr('name', 'gallery_id').val(image.id);
            $('#input-area').html(input);
            previewContainer.html(
                `<div class="p-2" style="flex: 0 0 50%;"><img src="${image.url}" style="max-width: 100%; margin: 10px; display: block;"></div>`
            );
        });
    }

    const tags = {!! json_encode($blog->tags ?? []) !!};
    if (tags.length > 0) {
        tags.forEach(tag => {
            let container = $('#new_tags_container');
            let input = $('<input>').attr('type', 'hidden').attr('name', 'tags[]').val(tag.id);
            container.append(input);

            let span = $('<span>').addClass('badge badge-primary m-1').text(tag.name);
            let icon = $('<i>').addClass('mdi mdi-close ml-2').css('cursor', 'pointer').on('click', function() {
                $(this).parent().remove();
                input.remove();
            });
            span.append(icon);
            container.append(span);
        });
    }

    $('#new_tag').on('keypress', function(e) {
        if (e.key === ',') {
            e.preventDefault();
            let tag = $(this).val().trim().replace(',', '');
            if (tag) {
                let isDuplicate = false;
                $('#new_tags_container span').each(function() {
                    if ($(this).text().trim() === tag) {
                        isDuplicate = true;
                        return false;
                    }
                });

                if (!isDuplicate) {
                    $.ajax({
                        url: '{{ route('admin.taxonomy-tag.searchOrCreate') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            tag: tag
                        },
                        success: function(res) {
                            if (res.id) {
                                let container = $('#new_tags_container');
                                let input = $('<input>').attr('type', 'hidden').attr('name',
                                        'tags[]')
                                    .val(res.id);
                                container.append(input);

                                let span = $('<span>').addClass('badge badge-primary m-1').text(
                                    tag);
                                let icon = $('<i>').addClass('mdi mdi-close ml-2').css('cursor',
                                    'pointer').on('click',
                                    function() {
                                        $(this).parent().remove();
                                        input.remove();
                                    });
                                span.append(icon);
                                container.append(span);
                                $('#new_tag').val('');
                            }
                        }
                    });
                } else {
                    alert('Tag already added.');
                }
            }
        } else {
            let query = $(this).val().trim();
            if (query.length > 0) {
                $.ajax({
                    url: '{{ route('admin.taxonomy-tag.search') }}',
                    method: 'GET',
                    data: {
                        query: query
                    },
                    success: function(res) {
                        let suggestions = $('#tag_suggestions');
                        suggestions.html('');
                        res.forEach(tag => {
                            let suggestion = $('<div>').addClass(
                                'suggestion-item list-group-item list-group-item-action bg-dark text-white'
                            ).text(tag.name).css('cursor', 'pointer').on('click',
                                function() {
                                    let container = $('#new_tags_container');
                                    if (container.find(`input[value="${tag.id}"]`)
                                        .length === 0) {
                                        let input = $('<input>').attr('type', 'hidden')
                                            .attr('name', 'tags[]').val(tag.id);
                                        container.append(input);

                                        let span = $('<span>').addClass(
                                            'badge badge-primary m-1').text(tag
                                            .name);
                                        let icon = $('<i>').addClass(
                                                'mdi mdi-close ml-2')
                                            .css('cursor', 'pointer').on('click',
                                                function() {
                                                    $(this).parent().remove();
                                                    input.remove();
                                                });
                                        span.append(icon);
                                        container.append(span);
                                        $('#new_tag').val('');
                                        suggestions.html('');
                                    }
                                });
                            suggestions.append(suggestion);
                        });
                    }
                });
            }
        }
    });
</script>
