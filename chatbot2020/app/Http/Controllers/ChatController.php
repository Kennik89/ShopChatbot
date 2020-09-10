<?php

namespace App\Http\Controllers;

use App\Models\ChatbotReport;
use App\Models\Greet;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function index()
    {
        $output = $this->getOutputAbout('greet') . " " . $this->getOutputAbout('provideHelp');
        $output = "CHATBOT: " . $output;
        return view('welcome')->with(['output' => $output]);
    }

    public function generateAnswer(Request $request)
    {
        $input = $request->input('question');

        $output = null;
        $outputInBottom = null;
        $input = strtolower($input);

        if ($input == "") {
            $output = $this->getOutputAbout('emptyInput');
        } else if (Str::contains($input, ["farvel", "vi ses", "tak"])) { //INTRODUCTION
            $output = $this->getOutputAbout('goodbye');

        } else if (Str::contains($input, ["køb", "søge", "lede"]) ) { // REQUEST A PRODUCT
            $products = Product::all()->pluck('type')->unique();

            if ($products->isNotEmpty()) {
                $headerOutput = $this->getOutputAbout('inStock');
                $hasMatch = false;

                foreach($products as $product) {
                    $numberProducts = Product::all()->where('type', $product)->get('stock');

                    if (str_contains($input, $product)) {
                        $hasMatch = true;
                        $inStorage = Product::where('type', $product)
                            ->where('stock', '!=', 0)
                            ->get(['name', 'price', 'brand']);

                        if ($inStorage->isNotEmpty()) {
                            $output .= $this->stringReplacements([$product, $numberProducts], $headerOutput) . PHP_EOL;
                            $output .= $this->priceListBuilder($inStorage) . PHP_EOL;
                        } else {
                            $rawOutput = $this->getOutputAbout('notInStock');
                            $outputInBottom .= $this->stringReplacements([$product], $rawOutput) . PHP_EOL;
                        }
                    }
                }
                $output .= $outputInBottom;

                if (!$hasMatch) {
                    $output = $this->getOutputAbout('noInCategory');
                }
            }
        } else if (Str::contains($input, ["har", "på lager"]) ) { // SHOW THE LIST OF PRODUCTS
            $productTypes = Product::all()->sortBy('type')->pluck('type')->unique()->toArray();
            $stringOfProducts = implode(", ", $productTypes);

            $output .= $this->getOutputAbout('category') . PHP_EOL;
            $output .= $stringOfProducts;
        } else { // UNIDENTIFIED QUESTION
            $output = $this->getOutputAbout('clarify');

            ChatbotReport::create([
                'user_input' => $input,
                'chatbot_output' => $output,
            ]);
        }

        return view('welcome')->with(['output' => $output]);
    }

    private function getOutputAbout($type, $condition = null) {
        $collection = Greet::where('type', $type);
        if ($condition != null) {
            $collection->where('condition', $condition);
        }
        $output = $collection->inRandomOrder()->first()->output;

        return $output;
    }

    private function priceListBuilder($inStorages) {
        $text = "";
        foreach($inStorages as $product) {
            $text .= $product->name . "\t\t";
            $text .= "BRAND: " . $product->brand . "\t\t";
            $text .= "PRIS: " . $product->price . PHP_EOL;
        }

        return $text;

    }

    private function stringReplacements($insertString, $text) {
        $replaced = str_replace("{0}", $insertString[0], $text);
        $replaced = ucfirst($replaced);

        return $replaced;
    }
}
