@extends('admin._layouts.default')

@section('main')

	<h1>
		Destinations & Pricing <a href="{{ URL::route('admin.destinations.create') }}" class="btn btn-success"><i class="icon-plus-sign"></i> Add New Destination</a>
	</h1>

	<hr>

	{{ Notification::showAll() }}
        <div ng-app="limoApp" ng-controller="mainController">
	<table class="table table-striped">
		<thead>
			<tr>
				<th>#</th>
				<th>Source</th>
				<th>To CBD</th>
                                <th>To Domestic Airport</th>
                                <th>To Int'l Airport</th>
				<th><i class="icon-cog"></i></th>
			</tr>
		</thead>
		<tbody>
                    <tr ng-repeat="dest in data.destinations">
                        <td>[[dest.id]]</td>
                        <td>[[dest.name]]</td>
                        <td>[[dest.cbd]]</td>
                        <td>[[dest.dom]]</td>
                        <td>[[dest.intl]]</td>
                    </tr>
		</tbody>
	</table>
        </div>

@stop
<script type="text/javascript">
  function init($scope)
  {
      alert($scope);
  }
    
</script>
