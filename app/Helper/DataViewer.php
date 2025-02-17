<?php
	
	namespace App\Helper;
	use Validator;
	trait DataViewer {

		protected $operators=[
			'equal' =>'=',
			'not_equal'=>'<>',
			'gater_than'=>'>',
			'less_than'=>'<',
			'grater_or_equal'=>'>=',
			'less_or_equal'=>'<=',
			'in'=>'IN',
			'like'=>'like'

		];
		public function scopeSearchPaginateAndOrder($query){
			$request=app()->make('request');
			$v=Validator::make($request->only([
				'column','direction','per_page',
				'search_column','search_operator','search_input'
			]),
			[
				'column'=>'required|alpha_dash|in:'.implode(',',self::$columns),
				'direction'=>'required|in:asc,desc',
				'per_page'=>'integer|min:1',
				'search_column'=>'required|alpha_dash|in:'.implode(',',self::$columns),
				'search_operator'=>'required|alpha_dash|in:'.implode(',',array_keys($this->operators)),
				'search_input'=>'max:255'
			]);

			$orderBycolumn=$request->column;
			$orderBydirec=$request->direction;
			$string_column=implode("','",self::$columns);
			if($v->fails()){
				dd($v->messages());
			}
			//echo $string_column;die;
			return $query
			//->select('id','name','email','phone')
			->orderBy($orderBycolumn,$orderBydirec)
			->where(function($query) use ($request){
				if($request->search_input){
					if($request->search_operator=='in'){
						$query->whereIn($request->search_column,explode(',',$request->search_input));
					}
					else if($request->search_operator=='like'){
						$query->where($request->search_column,'LIKE','%'.$request->search_input.'%');
					}
					else{
						$query->where($request->search_column,$this->operators[$request->search_operator],$request->search_input);
					}
				}
			})
			->paginate($request->per_page);
		}

	}


?>