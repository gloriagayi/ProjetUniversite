<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Rating;
use App\Models\Critere;
use App\Models\Universite;



class ProductRatings extends Component
{

    public $rating;
    public $comment;
    public $currentId;
    public $universite;
    public $criteres;
    public $hideForm;
    public $critere;
    

    protected $rules = [
        'rating' => ['required', 'in:1,2,3,4,5'],
        'comment' => 'required',

    ];

    

public function render()
    {
        $comments = Rating::where('product_id', $this->universite->id)->where('status', 1)->with('user')->get();
        return view('livewire.product-ratings', compact('comments'));
    }

    
      public function mount()
    {
        if(auth()->user()){
            $rating = Rating::where('user_id', auth()->user()->id)->where('product_id', $this->universite->id)/* ->where('critere_id', $this->critere->id) */->first();
            if (!empty($rating)) {
                $this->rating  = $rating->rating;
                $this->comment = $rating->comment;
                $this->currentId = $rating->id;
            }
        }
        return view('livewire.product-ratings');
    }  

     /* public function mount()
{
    $criteres = Critere::all();
    if(auth()->user() && $this->universite && $this->critere){
        $rating = Rating::where('user_id', auth()->user()->id)
                        ->where('product_id', $this->universite->id)
                        ->where('critere_id', $this->critere->id)
                        ->first();
        if (!empty($rating)) {
            $this->rating  = $rating->rating;
            $this->comment = $rating->comment;
            $this->currentId = $rating->id;
        }
    }
    return view('livewire.product-ratings');
} 
 */

    public function delete($id)
    {
        $criteres = Critere::all();
        $rating = Rating::where('id', $id)->first();
        if ($rating && ($rating->user_id == auth()->user()->id)) {
            $rating->delete();
        }
        if ($this->currentId) {
            $this->currentId = '';
            $this->rating  = '';
            $this->comment = '';
        }
    }

    public function rate()
    {
        $rating = Rating::where('user_id', auth()->user()->id)->where('product_id', $this->universite->id)/* ->where('critere_id',$this->critere->id) */->first();
        $this->validate();
        if (!empty($rating)) {
            $rating->user_id = auth()->user()->id;
            $rating->product_id = $this->universite->id;
          $rating->critere_id = 1;
           $rating->rating = $this->rating;
            $rating->comment = $this->comment;
            $rating->status = 1;
            try {
                $rating->update();
            } catch (\Throwable $th) {
                throw $th;
            }
            session()->flash('message', 'Success!');
        } else {
            $rating = new Rating;
            $rating->user_id = auth()->user()->id;
            $rating->product_id = $this->universite->id;
            $rating->critere_id = 1;
            $rating->rating = $this->rating;
            $rating->comment = $this->comment;
            $rating->status = 1;
            try {
                $rating->save();
            } catch (\Throwable $th) {
                throw $th;
            }
            $this->hideForm = true;
        }
    } 


   /*  public function rate()
{
    $criteres = Critere::all();
    // Valider les données
    $this->validate();

    // Vérifier si l'utilisateur est connecté
    if (auth()->user()) {
        // Parcourir chaque critère
        foreach ($this->critere as $key => $value) {
            // Rechercher une évaluation existante pour ce critère
            $rating = Rating::where('user_id', auth()->user()->id)
                            ->where('product_id', $this->universite->id)
                            ->where('critere', $key)
                            ->first();

            // Si une évaluation existe, mettre à jour
            if ($rating) {
                $rating->rating = $value;
                $rating->comment = $this->comments[$key] ?? null;
                $rating->save();
            } else {
                // Sinon, créer une nouvelle évaluation
                $rating = new Rating([
                    'user_id' => auth()->user()->id,
                    'product_id' => $this->universite->id,
                    'critere_id' => $key,
                    'rating' => $value,
                    'comment' => $this->comments[$key] ?? null,
                    'status' => 1,
                ]);
                $rating->save();
            }
        }

        // Afficher un message de succès
        session()->flash('message', 'Success!');
    }

    // Masquer le formulaire après avoir soumis les évaluations
    $this->hideForm = true;
}



 */
}