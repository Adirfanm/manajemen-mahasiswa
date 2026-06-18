<?php

namespace App\Http\Controllers;

use App\Entities\Mahasiswa;
use App\Services\MahasiswaManager;
use App\Services\SearchService;
use App\Services\SortService;
use Exception;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        try {
            $manager = new MahasiswaManager();
            $data = $manager->getAll();

            $keyword = trim($request->query('keyword', ''));
            $searchMethod = $request->query('search_method', 'linear');
            $sortMethod = $request->query('sort_method', 'none');

            if ($keyword !== '') {
                if ($searchMethod === 'binary') {
                    $found = SearchService::binarySearchByNim($data, $keyword);
                    $data = $found ? [$found] : [];
                } elseif ($searchMethod === 'sequential') {
                    $data = SearchService::sequentialSearch($data, $keyword);
                } else {
                    $data = SearchService::linearSearch($data, $keyword);
                }
            }

            if ($sortMethod === 'bubble_nama') {
                $data = SortService::bubbleSortByNama($data);
            } elseif ($sortMethod === 'selection_nim') {
                $data = SortService::selectionSortByNim($data);
            } elseif ($sortMethod === 'merge_semester') {
                $data = SortService::mergeSortBySemester($data);
            }

            $pointerSample = $manager->getByIndexUsingPointer(0);

            return view('mahasiswa.index', compact(
                'data',
                'keyword',
                'searchMethod',
                'sortMethod',
                'pointerSample'
            ));
        } catch (Exception $e) {
            return view('mahasiswa.index', [
                'data' => [],
                'keyword' => '',
                'searchMethod' => 'linear',
                'sortMethod' => 'none',
                'pointerSample' => null,
            ])->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function create()
    {
        return view('mahasiswa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        try {
            $manager = new MahasiswaManager();

            $mahasiswa = new Mahasiswa(
                $validated['nim'],
                $validated['nama'],
                $validated['email'],
                $validated['jurusan'],
                (int) $validated['semester']
            );

            $manager->add($mahasiswa);

            return redirect()
                ->route('mahasiswa.index')
                ->with('success', 'Data mahasiswa berhasil ditambahkan.');
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit(string $nim)
    {
        try {
            $manager = new MahasiswaManager();
            $mahasiswa = $manager->findByNim($nim);

            if ($mahasiswa === null) {
                abort(404);
            }

            return view('mahasiswa.edit', compact('mahasiswa'));
        } catch (Exception $e) {
            return redirect()
                ->route('mahasiswa.index')
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, string $nim)
    {
        $validated = $request->validate($this->rules());

        try {
            $manager = new MahasiswaManager();

            $mahasiswa = new Mahasiswa(
                $validated['nim'],
                $validated['nama'],
                $validated['email'],
                $validated['jurusan'],
                (int) $validated['semester']
            );

            $manager->update($nim, $mahasiswa);

            return redirect()
                ->route('mahasiswa.index')
                ->with('success', 'Data mahasiswa berhasil diperbarui.');
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(string $nim)
    {
        try {
            $manager = new MahasiswaManager();
            $manager->delete($nim);

            return redirect()
                ->route('mahasiswa.index')
                ->with('success', 'Data mahasiswa berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()
                ->route('mahasiswa.index')
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    private function rules(): array
    {
        return [
            'nim' => [
                'required',
                'regex:/^[0-9]{8,12}$/'
            ],
            'nama' => [
                'required',
                'regex:/^[A-Za-z\s\.\']{3,100}$/u'
            ],
            'email' => [
                'required',
                'email'
            ],
            'jurusan' => [
                'required',
                'regex:/^[A-Za-z\s]{2,100}$/u'
            ],
            'semester' => [
                'required',
                'integer',
                'between:1,14'
            ],
        ];
    }
}
