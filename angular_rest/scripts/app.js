var app = angular.module("app", ["ngRoute", "ngResource"])

.config(['$routeProvider', function($routeProvider)
{
		$routeProvider.when('/home', {
			templateUrl: 'templates/list.html',
			controller: 'HomeCtrl'
		})

		.when('/edit/:id', {
			templateUrl: 'templates/edit.html',
			controller: 'EditCtrl'
		})
		.when('/create', {
			templateUrl: 'templates/create.html',
			controller: 'CreateCtrl'
		})
		.otherwise({ redirectTo: '/home' });
}])

.controller('HomeCtrl', ['$scope', 'Books', '$route', function($scope, Books, $route)
{
	Books.get(function(data){
		$scope.books = data.response; 
	});
	
	$scope.remove = function(id){
		if(confirm("Deseja excluir esse registro?")){
			Books.delete({id:id}).$promise.then(function(data){
				if(data.response){
					$route.reload();
				}
			})
		}
		
	}
}])

.controller('EditCtrl', ['$scope', 'Books', '$routeParams', function($scope, Books, $routeParams)
{
	$scope.settings = {
		pageTitle: "Editar livros",
		action: "Edit"
	};
	
	Books.get({id:$routeParams.id}, function(data){
		$scope.book = data.response;
	});
	
	$scope.submit = function(){
		Books.update({id:$scope.book.id}, {book:$scope.book}, function(data){
			$scope.settings.success = "Livro alterado com sucesso!";
		});
	}
}])

.controller('CreateCtrl', ['$scope', 'Books', function($scope, Books)
{
	$scope.settings = {
		pageTitle: "Novo Livro",
		action: "Create"
	};
	
	$scope.book = {
		name: "",
		author: "",
		pub_date: ""
	};
	
	$scope.submit = function()
	{
		Books.save({book:$scope.book}).$promise.then(function(data){
			if(data.response){
				angular.copy({}, $scope.book);
				$scope.settings.success = "Livro criado com sucesso!";
			}
		})
	}
}])

.factory('Books', ["$resource", function($resource){
	return $resource("http://localhost/ci_rest/books/:id", {id:"@id"}, {
		update: {method: "PUT", params: {id: "@id"}}
	})
}])