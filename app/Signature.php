<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Migrations\Migration;

class Signature extends Model
{
    //
	protected $fillable = ['name', 'email', 'body', 'flagged_at'];

		/**
	 * Ignore flagged signatures.
	 *
	 * @param $query
	 * @return mixed
	 */
	public function scopeIgnoreFlagged($query)
	{
		return $query->where('flagged_at', null);
	}

	/**
	 * Flag the given signature.
	 *
	 * @return bool
	 */
	public function flag()
	{
		return $this->update(['flagged_at' => \Carbon\Carbon::now()]);
	}
	
	/**
 * Get the user Gravatar by their email address.
 *
 * @return string   
 */
public function getAvatarAttribute()
{
    return sprintf('https://www.gravatar.com/avatar/%s?s=100', md5($this->email));
}

}

class CreateSignaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */	
    public function up()
    {
        Schema::create('signatures', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->text('body');
            $table->timestamp('flagged_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('signatures');
    }
	
	/**
* Field to be mass-assigned.
*
* @var array
*/
}

