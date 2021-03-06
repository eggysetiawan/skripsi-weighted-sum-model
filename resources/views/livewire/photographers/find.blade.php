<div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"> Find Fotografer</div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12" wire:ignore>
                            <select name="category" id="category" class="form-control" wire:model="category_find">

                                <option value="" selected>Semua Kategory</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->category }}">{{ ucfirst($category->category) }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="row">

                        @foreach ($criterias as $criteria)
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="{{ $criteria->name }}">{{ ucfirst($criteria->name) }}
                                    </label>

                                    <input type="number" name="{{ $criteria->name }}" id="{{ $criteria->name }}"
                                        min="1" max="{{ $criteria->max }}"
                                        wire:model.debounce.500ms="{{ $criteria->name }}"
                                        class="form-control criteria">
                                    <small>
                                        <small>
                                            max {{ $criteria->max }}.
                                        </small>
                                    </small>
                                </div>
                            </div>
                        @endforeach

                        <div class="form-group">
                            <x-score-parameter />
                        </div>

                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary btn-block" wire:click.prevent="sortMethod" @if (!$errors->isEmpty()) disabled @endif>Find</button>
                </div>
            </div>
        </div>
    </div>



    @if ($table)
        <div class="row justify-content-center">
            @include('layouts.livewire.loading')
        </div>

        <span class="inline-block" wire:loading.remove>

            <div class="row justify-content-center">
                <span class="text-center h4">
                    Total nilai input kriteria : {{ $totalCriteriaValue }}
                </span>
            </div>

            {{-- table bobot --}}
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Bobot</div>

                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kriteria</th>
                                        <th class="text-center">Nilai (Input kriteria / Total nilai input kriteria)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($criterias as $criteria)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ ucfirst($criteria->name) }}</td>
                                            <td class="text-center">{{ $weight[$loop->index] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- table score --}}
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Nilai fotografer berdasarkan kuisioner</div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fotografer</th>
                                        @foreach ($criterias as $criteria)
                                            <th>{{ ucfirst($criteria->name) }}</th>
                                        @endforeach
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($photographers as $photographer)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ ucfirst($photographer->name) }}</td>
                                            @foreach ($photographer->scores as $score)
                                                <td class="text-center">{{ $score->score }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- table min & max --}}
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Min - Max Kriteria</div>

                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Kriteria</th>
                                        @foreach ($criterias as $criteria)
                                            <th class="text-center">{{ ucfirst($criteria->name) }}</th>
                                        @endforeach
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>Minimum</td>
                                        @foreach ($minCriteria as $min)
                                            <td class="text-center">{{ $min }}</td>
                                        @endforeach
                                    </tr>

                                    <tr>
                                        <td>Maksimum</td>
                                        @foreach ($maxCriteria as $max)
                                            <td class="text-center">{{ $max }}</td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                {{-- normalisasi maut --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Normalisasi MAUT</div>

                        <div class="card-body">
                            <table class="table table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fotografer</th>
                                        @foreach ($criterias as $criteria)
                                            <th>{{ ucfirst($criteria->name) }}</th>
                                        @endforeach
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($photographers as $photographer)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ ucfirst($photographer->name) }}</td>
                                            @foreach ($photographer->scores as $score)
                                                <td class="text-center">
                                                    {{ ($score->score - $minCriteria[$score->criteria_id - 1]) / ($maxCriteria[$score->criteria_id - 1] - $minCriteria[$score->criteria_id - 1]) }}
                                                </td>
                                            @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- normalisasi weighted --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Normalisasi Weighted Sum Model</div>

                        <div class="card-body">
                            <table class="table table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fotografer</th>
                                        @foreach ($criterias as $criteria)
                                            <th>{{ ucfirst($criteria->name) }}</th>
                                        @endforeach
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($photographers as $photographer)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ ucfirst($photographer->name) }}</td>
                                            @foreach ($photographer->scores->load('criteria') as $score)
                                                @php
                                                    $benefical = $score->score / $minCriteria[$score->criteria_id - 1];
                                                    if ($score->criteria->is_benefical == 1) {
                                                        $benefical = $score->score / $maxCriteria[$score->criteria_id - 1];
                                                    }
                                                @endphp
                                                <td class="text-center">
                                                    {{ $normalizeScoreWeighted = $benefical * $weight[$score->criteria_id - 1] }}
                                                </td>
                                            @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-12">
                    <p>
                        Disarankan memilih weighted sum model karena bobot lebih besar nah jika fotografer tidak bisa
                        selanjutnya di sarankan untuk memilih yang kedua dari metode maut karena lebih akurat karena dan
                        jika photografer kedua tidak bisa disarankan memilih fotografer kedua metode weighted sum model
                        karena bobotnya lebih besar dan begitu terus selanjutnya.
                    </p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Sort by MAUT</div>
                        <div class="card-body">
                            <div class="row">
                                <table class="table table-striped">
                                    <thead>
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Preferensi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($mauts as $maut)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $maut['name'] }}</td>
                                                <td>{{ $maut['preference'] }}</td>
                                                <td>
                                                    <div class="text-center">
                                                        <button wire:click="editMaut('{{ $maut['name'] }}')"
                                                            class="btn btn-success btn-sm" data-toggle="modal"
                                                            data-target="#exampleModalMaut-{{ $maut['username'] }}">
                                                            Pilih Fotografer
                                                        </button>
                                                        <div class="mt-2">
                                                            <a href="{{ route('photographer.show', $maut['username']) }}"
                                                                class="btn btn-info btn-sm" target="_blank">Lihat
                                                                Profil</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="exampleModalMaut-{{ $maut['username'] }}"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                                                aria-hidden="true" wire:ignore>
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalCenterTitle">Order
                                                                by Maut</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="name">Fotografer:</label>
                                                                <input type="text" wire:model="photographerMaut"
                                                                    class="form-control" disabled>
                                                            </div>
                                                            {{-- tanggal --}}
                                                            <div class="form-group">
                                                                <label for="date">Pilih Tanggal</label>

                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <i class="far fa-calendar-alt"></i>
                                                                        </span>
                                                                    </div>
                                                                    <input type="date" id="date"
                                                                        wire:model.debounce.180s="dateMaut"
                                                                        class="form-control @error('dateMaut') is-invalid @enderror">
                                                                    @error('dateMaut')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            {{-- mulai --}}
                                                            <div class="form-group">
                                                                <label for="startMaut">Mulai</label>
                                                                <input type="time" wire:model.debounce.180s="startMaut"
                                                                    class="form-control" id="startMaut">
                                                            </div>

                                                            {{-- selesai --}}
                                                            <div class="form-group">
                                                                <label for="endMaut">Selesai</label>
                                                                <input type="time" wire:model.debounce.180s="endMaut"
                                                                    class="form-control" id="endMaut">
                                                            </div>

                                                            {{-- note --}}
                                                            <div class="form-group">
                                                                <label for="noteMaut">Catatan</label>
                                                                <textarea wire:model.debounce.180s="noteMaut"
                                                                    id="noteMaut" class="form-control"
                                                                    placeholder="Berikan catatan untuk sesi foto.."></textarea>
                                                            </div>

                                                            {{-- name --}}
                                                            <div class="form-group">
                                                                <label for="nameMaut">Nama Pemesan</label>
                                                                <input type="text" wire:model.debounce.180s="nameMaut"
                                                                    id="nameMaut" class="form-control"
                                                                    value="{{ auth()->user()->name }}"
                                                                    placeholder="Masukan nama customer..">
                                                            </div>

                                                            {{-- mobile --}}
                                                            <div class="form-group">
                                                                <label for="mobileMaut">No Hp</label>
                                                                <input type="number"
                                                                    wire:model.debounce.180s="mobileMaut"
                                                                    value="{{ auth()->user()->mobile }}"
                                                                    id="mobileMaut" class="form-control"
                                                                    placeholder="Masukan nomor Hp customer..">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="emailmaut">Alamat Email</label>
                                                                <input type="email" wire:model.debounce.180s="emailMaut"
                                                                    id="emailMaut" class="form-control"
                                                                    value="{{ auth()->user()->email }}"
                                                                    placeholder="Masukan email customer..">
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary"
                                                                wire:click.prevent="orderMaut({{ $maut['id'] }})">Buat
                                                                Order
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Sort by Weighted Sum Model</div>
                        <div class="card-body">
                            <div class="row">
                                <table class="table table-striped">
                                    <thead>
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Preferensi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($weighteds as $weighted)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $weighted['name'] }}</td>
                                                <td>{{ $weighted['preference'] }}</td>
                                                <td>
                                                    <div class="text-center">
                                                        <button wire:click="editMaut('{{ $weighted['name'] }}')"
                                                            class="btn btn-success btn-sm" data-toggle="modal"
                                                            data-target="#exampleModalWeighted-{{ $weighted['username'] }}">
                                                            Pilih Fotografer
                                                        </button>

                                                        <div class="mt-2">
                                                            <a href="{{ route('photographer.show', $weighted['username']) }}"
                                                                class="btn btn-info btn-sm" target="_blank">Lihat
                                                                Profil</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Modal -->
                                            <div class="modal fade"
                                                id="exampleModalWeighted-{{ $weighted['username'] }}" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalCenterTitle"
                                                aria-hidden="true" wire:ignore>
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalCenterTitle">Order
                                                                by Weighted Sum Model</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="name">Fotografer:</label>
                                                                <input type="text" wire:model="photographerMaut"
                                                                    class="form-control" disabled>
                                                            </div>
                                                            {{-- tanggal --}}
                                                            <div class="form-group">
                                                                <label for="date">Pilih Tanggal</label>

                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <i class="far fa-calendar-alt"></i>
                                                                        </span>
                                                                    </div>
                                                                    <input type="date" id="date"
                                                                        wire:model.debounce.180s="dateMaut"
                                                                        class="form-control @error('dateMaut') is-invalid @enderror">
                                                                    @error('dateMaut')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            {{-- mulai --}}
                                                            <div class="form-group">
                                                                <label for="startMaut">Mulai</label>
                                                                <input type="time" wire:model.debounce.180s="startMaut"
                                                                    class="form-control" id="startMaut">
                                                            </div>

                                                            {{-- selesai --}}
                                                            <div class="form-group">
                                                                <label for="endMaut">Selesai</label>
                                                                <input type="time" wire:model.debounce.180s="endMaut"
                                                                    class="form-control" id="endMaut">
                                                            </div>

                                                            {{-- note --}}
                                                            <div class="form-group">
                                                                <label for="noteMaut">Catatan</label>
                                                                <textarea wire:model.debounce.180s="noteMaut"
                                                                    id="noteMaut" class="form-control"
                                                                    placeholder="Berikan catatan untuk sesi foto.."></textarea>
                                                            </div>

                                                            {{-- name --}}
                                                            <div class="form-group">
                                                                <label for="nameMaut">Nama Pemesan</label>
                                                                <input type="text" wire:model.debounce.180s="nameMaut"
                                                                    id="nameMaut" class="form-control"
                                                                    value="{{ auth()->user()->name }}"
                                                                    placeholder="Masukan nama customer..">
                                                            </div>

                                                            {{-- mobile --}}
                                                            <div class="form-group">
                                                                <label for="mobileMaut">No Hp</label>
                                                                <input type="number"
                                                                    wire:model.debounce.180s="mobileMaut"
                                                                    value="{{ auth()->user()->mobile }}"
                                                                    id="mobileMaut" class="form-control"
                                                                    placeholder="Masukan nomor Hp customer..">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="emailmaut">Alamat Email</label>
                                                                <input type="email" wire:model.debounce.180s="emailMaut"
                                                                    id="emailMaut" class="form-control"
                                                                    value="{{ auth()->user()->email }}"
                                                                    placeholder="Masukan email customer..">
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary"
                                                                wire:click.prevent="orderMaut({{ $weighted['id'] }})">Buat
                                                                Order
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </span>
    @endif

</div>
