<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use App\Trait\FormatMoneyTrait;
use App\Http\Requests\StoreRuleRequest;
use App\Http\Requests\UpdateRuleRequest;

class RuleController extends Controller
{
    use FormatMoneyTrait;

    public function index()
    {
        $rules = Rule::all();

        foreach ($rules as $rule) {
            $rule->amount = $this->Money($rule->amount);
        }

        return view('rules.index', ['menu' => 'rules', 'rules' => $rules]);
    }

    public function create()
    {
        return view('rules.create', [
            'menu' => 'rules',
        ]);
    }

    public function store(StoreRuleRequest $request)
    {
        $request->validated();

        Rule::create([
            'name' => $request->name,
            'aliquot' => $request->aliquot,
            'amount' => $request->amount,
        ]);

        return redirect()->route('rules.index', [
            'menu' => 'rules',
            ])->with('success', 'Regra cadastrada com sucesso!');
    }

    public function show(Rule $rule)
    {
        return view('rules.edit', [
            'menu' => 'rules',
            'rule' => $rule,
        ]);
    }

    public function edit(Rule $rule)
    {
        return view('rules.edit', [
            'menu' => 'rules',
            'rule' => $rule,
        ]);
    }

    public function update(UpdateRuleRequest $request, Rule $rule)
    {
        $request->validated();

        $rule->update([
            'name' => $request->name,
            'aliquot' => $request->aliquot,
            'amount' => $request->amount,
        ]);

        return redirect()->route('rules.index', [
            'menu' => 'rules',
        ])->with('success', 'Regra atualizada com sucesso!');
    }

    public function destroy(Rule $rule)
    {
        $rule->delete();

        return redirect()->route('rules.index', [
            'menu' => 'rules',
        ])->with('success', 'Regra excluída com sucesso!');
    }
}
