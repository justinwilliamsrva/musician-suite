@props(['$musicianNumber', '$allMusicians'])

@php
    $instrumentErrors = !is_array($errors) && $errors->has('musicians.'.$musicianNumber.'.instruments');
@endphp

<select multiple name="musicians[{{ $musicianNumber }}][musician_select]" id="{{ 'musician-select'.$musicianNumber }}" class="@if(!is_array($errors) && $errors->has('musicians.'.$musicianNumber.'.instruments')) input-validation-error @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
    @foreach($allMusicians as $musician)
        <option @if(old("musicians.$musicianNumber.musician_select") == $musician->id) selected @endif value="{{ $musician->id }}">{{ $musician->name }}</option>
    @endforeach
</select>

<script>
    var number = {{ $musicianNumber }};
    $('#musician-select'+number).select2({
        minimumResultsForSearch: 0,
        minimumInputLength: 5,
        maximumSelectionLength: 1,
        placeholder: 'Search for Musician',
        // matcher: function(params, data) {
        //     // If there is no search term, return all options
        //     if ($.trim(params.term) === '') {
        //     return data;
        //     }

        //     // Otherwise, compare the search term with the option text
        //     if (data.text === params.term) {
        //     return data;
        //     }

        //     // If there is no match, return null
        //     return null;
        // }
    });
</script>
