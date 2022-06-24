import React, {useState, useEffect, useRef} from 'react';
import {
  StyleSheet,
  Text,
  View,
  Image,
  FlatList,
  TouchableOpacity,
  ActivityIndicator,
  TextInput,
  Animated,
  Dimensions,
  Modal,
  ScrollView,
} from 'react-native';
import NavPages from '../../componentes/NavPages';
import CardDetalhes from '../../componentes/CardDetalhes';
import Globais from '../../componentes/Globais';
import CheckBox from '@react-native-community/checkbox';
import axios from 'axios';

export default function App({route}) {
  const url = 'http://www.racsstudios.com/api/v1';
  const [dados, setDados] = useState([]);
  const [loading, setLoading] = useState(false);
  const [additem, setAdditem] = useState(3);
  const [filtro, setFiltro] = useState(dados);
  const [filtro2, setFiltro2] = useState(filtro);
  const [filtro3, setFiltro3] = useState(filtro2);
  const [organizar, setOrganizar] = useState('desc');
  const [ordenado, setOrdenado] = useState(false);
  const [iconpreco, setIconpreco] = useState(
    require('../../images/menupages/preco.png'),
  );
  const [busca, setBusca] = useState('');
  const [mostrarx, setMostrarx] = useState(false);
  const [mostrarfiltro, setMostrarfiltro] = useState(false);
  const [mostrarbusca, setMostrarbusca] = useState(false);
  const [mostrarLoading, setMostrarLoading] = useState(false);
  const input = useRef();
  const scrollRef = useRef();
  const scrollY = new Animated.Value(0);
  const diffClamp = Animated.diffClamp(scrollY, 0, 130);
  const translate = diffClamp.interpolate({
    inputRange: [0, 130, 260],
    outputRange: [0, -130, -260],
  });

  let icon = route.params?.icon;
  let tipo = route.params?.tipo;
  let pesquisa = route.params?.pesquisa;
  let buscaSug = route.params?.busca;

  const [iconestrelas, setIconestrelas] = useState(
    require('../../images/menupages/estrelas.png'),
  );
  const [icondistancia, setIcondistancia] = useState(
    require('../../images/menupages/distancia.png'),
  );
  const [iconmaisprocurados, setIconmaisprocurados] = useState(
    require('../../images/menupages/maisprocurados.png'),
  );
  const [iconfiltro, setIconfiltro] = useState(
    require('../../images/menupages/filtro.png'),
  );

  useEffect(() => {
    loadApi();
  }, []);

  useEffect(() => {
    if (Globais.distancia != null) {
      setFiltro(
        Globais.distancia?.filter(item => {
          if (item.segmento == buscaSug) {
            return true;
          }
        }),
      );
    } else {
      setFiltro(
        dados.filter(item => {
          if (item.segmento == buscaSug) {
            return true;
          }
        }),
      );
    }
  }, [dados]);

  useEffect(() => {
    setFiltro2(
      filtro.filter(item => {
        if (item.segmento == buscaSug) {
          return true;
        }
      }),
    );
  }, [filtro]);

  useEffect(() => {
    setLoading(true);
    setTimeout(() => {
      setLoading(false);
      setFiltro3(
        filtro2.filter((item, indice) => {
          if (item.segmento == buscaSug && indice < additem) {
            return true;
          }
        }),
      );
    }, 10);
  }, [filtro2, additem]);

  const buscar = () => {
    if (busca == '') {
      setFiltro(dados);
    } else {
      setMostrarbusca(true);
      setFiltro(
        filtro2.filter(item => {
          if (
            item.nomeFantasia.toLowerCase().indexOf(busca.toLowerCase()) > -1 ||
            item.chaves.toLowerCase().indexOf(busca.toLowerCase()) > -1
          ) {
            return true;
          } else {
            return false;
          }
        }),
      );
    }
  };

  const limpaBusca = () => {
    setFiltroLigado(false);
    setFiltro(
      dados.filter(item => {
        if (item.segmento == buscaSug) {
          return true;
        }
      }),
    );
  };

  async function loadApi() {
    if (loading) return;
    setLoading(true);
    const response = await axios.get(`${url}/allapps`);
    setTimeout(() => setDados(response.data.apps), 100);
    setTimeout(() => {
      setLoading(false);
    }, 250);
  }

  const btnfiltro = tipo => {
    if (organizar == 'asc') {
      setOrganizar('desc');
      {
        tipo == 'preco'
          ? filtroPreco(organizar)
          : tipo == 'avaliacao'
          ? filtroAvaliacao()
          : tipo == 'distancia'
          ? filtroDistancia()
          : tipo == 'maisprocurados'
          ? filtroMaisprocurados()
          : filtroFiltro();
      }
    } else {
      setOrganizar('asc');
      {
        tipo == 'preco'
          ? filtroPreco(organizar)
          : tipo == 'avaliacao'
          ? filtroAvaliacao()
          : tipo == 'distancia'
          ? filtroDistancia()
          : tipo == 'maisprocurados'
          ? filtroMaisprocurados()
          : filtroFiltro();
      }
    }
  };

  const filtroPreco = tipo => {
    if (tipo == 'asc') {
      filtro2.sort((a, b) =>
        a.custoMedio > b.custoMedio ? -1 : b.custoMedio > a.custoMedio ? 1 : 0,
      );
      setOrdenado('Avaliados com Maior custo');
      setIconpreco(require('../../images/menupages/preco0.png'));
      setIconestrelas(require('../../images/menupages/estrelas.png'));
      setIcondistancia(require('../../images/menupages/distancia.png'));
      setIconmaisprocurados(
        require('../../images/menupages/maisprocurados.png'),
      );
      setIconfiltro(require('../../images/menupages/filtro.png'));
    } else {
      filtro2.sort((a, b) =>
        a.custoMedio > b.custoMedio ? 1 : b.custoMedio > a.custoMedio ? -1 : 0,
      );
      setOrdenado('Avaliados com Menor Custo');
      setIconpreco(require('../../images/menupages/preco1.png'));
      setIconestrelas(require('../../images/menupages/estrelas.png'));
      setIcondistancia(require('../../images/menupages/distancia.png'));
      setIconmaisprocurados(
        require('../../images/menupages/maisprocurados.png'),
      );
      setIconfiltro(require('../../images/menupages/filtro.png'));
    }
    setAdditem(3);
    setFiltro(filtro2);
  };
  const filtroAvaliacao = () => {
    filtro2.sort((a, b) =>
      a.estrelas > b.estrelas ? -1 : b.estrelas > a.estrelas ? 1 : 0,
    );
    setOrdenado('Melhores Avaliados');
    setIconpreco(require('../../images/menupages/preco.png'));
    setIconestrelas(require('../../images/menupages/estrelas1.png'));
    setIcondistancia(require('../../images/menupages/distancia.png'));
    setIconmaisprocurados(require('../../images/menupages/maisprocurados.png'));
    setIconfiltro(require('../../images/menupages/filtro.png'));
    setFiltro(filtro2);
    setAdditem(3);
  };
  const filtroDistancia = () => {
    filtro2.sort((a, b) =>
      a.distancia > b.distancia ? 1 : b.distancia > a.distancia ? -1 : 0,
    );
    setOrdenado('Mais Próximos de Você');
    setIconpreco(require('../../images/menupages/preco.png'));
    setIconestrelas(require('../../images/menupages/estrelas.png'));
    setIcondistancia(require('../../images/menupages/distancia1.png'));
    setIconmaisprocurados(require('../../images/menupages/maisprocurados.png'));
    setIconfiltro(require('../../images/menupages/filtro.png'));
    setFiltro(filtro2);
    setAdditem(3);
  };
  const filtroMaisprocurados = () => {
    filtro2.sort((a, b) =>
      parseInt(a.visualizacao) > parseInt(b.visualizacao)
        ? -1
        : parseInt(b.visualizacao) > parseInt(a.visualizacao)
        ? 1
        : 0,
    );
    setOrdenado('Mais Procurados');
    setIconpreco(require('../../images/menupages/preco.png'));
    setIconestrelas(require('../../images/menupages/estrelas.png'));
    setIcondistancia(require('../../images/menupages/distancia.png'));
    setIconmaisprocurados(
      require('../../images/menupages/maisprocurados1.png'),
    );
    setIconfiltro(require('../../images/menupages/filtro.png'));
    setFiltro(filtro2);
    setAdditem(3);
  };
  const filtroFiltro = () => {
    setMostrarfiltro(true);
    setIconfiltro(require('../../images/menupages/filtro0.png'));
    setIconpreco(require('../../images/menupages/preco.png'));
    setIconestrelas(require('../../images/menupages/estrelas.png'));
    setIcondistancia(require('../../images/menupages/distancia.png'));
    setIconmaisprocurados(require('../../images/menupages/maisprocurados.png'));
  };

  const [selectEstacionamento, setSelectEstacionamento] = useState(false);
  const selectionEstacionamento = () => {
    setSelectEstacionamento(!selectEstacionamento);
  };

  const [selectPiscina, setSelectPiscina] = useState(false);
  const selectionPiscina = () => {
    setSelectPiscina(!selectPiscina);
  };

  const [selectArcondicionado, setSelectArcondicionado] = useState(false);
  const selectionArcondicionado = () => {
    setSelectArcondicionado(!selectArcondicionado);
  };

  const [selectRefeicao, setSelectRefeicao] = useState(false);
  const selectionRefeicao = () => {
    setSelectRefeicao(!selectRefeicao);
  };

  const [selectAcademia, setSelectAcademia] = useState(false);
  const selectionAcademia = () => {
    setSelectAcademia(!selectAcademia);
  };

  const [selectWifi, setSelectWifi] = useState(false);
  const selectionWifi = () => {
    setSelectWifi(!selectWifi);
  };

  const [selectAcessibilidade, setSelectAcessibilidade] = useState(false);
  const selectionAcessibilidade = () => {
    setSelectAcessibilidade(!selectAcessibilidade);
  };

  const [selectTrilhas, setSelectTrilhas] = useState(false);
  const selectionTrilhas = () => {
    setSelectTrilhas(!selectTrilhas);
  };

  const [selectBar, setSelectBar] = useState(false);
  const selectionBar = () => {
    setSelectBar(!selectBar);
  };

  const [selectAnimais, setSelectAnimais] = useState(false);
  const selectionAnimais = () => {
    setSelectAnimais(!selectAnimais);
  };

  const [filtroLigado, setFiltroLigado] = useState(false);
  const FiltrarDetalhes = () => {
    setMostrarfiltro(false);
    setOrdenado(false);
    let estacionamento = null;
    let piscina = null;
    let arcondicionado = null;
    let refeicao = null;
    let academia = null;
    let wifi = null;
    let acessibilidade = null;
    let trilhas = null;
    let bar = null;
    let animais = null;

    {
      selectEstacionamento ? (estacionamento = 1) : (estacionamento = 2);
    }
    {
      selectPiscina ? (piscina = 1) : (piscina = 2);
    }
    {
      selectArcondicionado ? (arcondicionado = 1) : (arcondicionado = 2);
    }
    {
      selectRefeicao ? (refeicao = 1) : (refeicao = 2);
    }
    {
      selectAcademia ? (academia = 1) : (academia = 2);
    }
    {
      selectWifi ? (wifi = 1) : (wifi = 2);
    }
    {
      selectAcessibilidade ? (acessibilidade = 1) : (acessibilidade = 2);
    }
    {
      selectTrilhas ? (trilhas = 1) : (trilhas = 2);
    }
    {
      selectBar ? (bar = 1) : (bar = 2);
    }
    {
      selectAnimais ? (animais = 1) : (animais = 2);
    }

    if (
      selectEstacionamento == 0 &&
      selectPiscina == 0 &&
      selectRefeicao == 0 &&
      selectAcademia == 0 &&
      selectWifi == 0 &&
      selectAcessibilidade == 0 &&
      selectTrilhas == 0 &&
      selectBar == 0 &&
      selectAnimais == 0 &&
      selectArcondicionado == 0
    ) {
      setFiltroLigado(false);
      limpaBusca();
    } else {
      setFiltroLigado(true);
      setMostrarLoading(false);
      setTimeout(() => {
        setMostrarLoading(true);
      }, 2000);
      if (Globais.distancia != null) {
        setFiltro2(
          Globais.distancia?.filter(item => {
            if (
              (item.complemeto.estacionamento == estacionamento ||
                item.complemeto.piscina == piscina ||
                item.complemeto.arcondicionado == arcondicionado ||
                item.complemeto.refeicao == refeicao ||
                item.complemeto.academia == academia ||
                item.complemeto.wiFi == wifi ||
                item.complemeto.acessibilidade == acessibilidade ||
                item.complemeto.trilhas == trilhas ||
                item.complemeto.bar == bar ||
                item.complemeto.animais == animais) &&
              item.segmento == buscaSug
            ) {
              return true;
            }
          }),
        );
      } else {
        setFiltro2(
          dados.filter(item => {
            if (
              (item.complemeto.estacionamento == estacionamento ||
                item.complemeto.piscina == piscina ||
                item.complemeto.arcondicionado == arcondicionado ||
                item.complemeto.refeicao == refeicao ||
                item.complemeto.academia == academia ||
                item.complemeto.wiFi == wifi ||
                item.complemeto.acessibilidade == acessibilidade ||
                item.complemeto.trilhas == trilhas ||
                item.complemeto.bar == bar ||
                item.complemeto.animais == animais) &&
              item.segmento == buscaSug
            ) {
              return true;
            }
          }),
        );
      }
    }
  };

  return (
    <View style={estilos.container}>
      <Animated.View
        style={{
          position: 'absolute',
          zIndex: 9,
          backgroundColor: '#f3f3f3',
          top: 0,
          transform: [{translateY: translate}],
        }}>
        <NavPages icon={icon} title={tipo} />
        <View
          style={{
            paddingHorizontal: 40,
            flexDirection: 'row',
            alignItems: 'center',
            marginTop: 10,
          }}>
          <View style={estilos.containerBusca}>
            <TextInput
              ref={input}
              onSubmitEditing={() => {
                buscar();
                input.current.blur();
                if (busca) setMostrarx(true);
                setMostrarLoading(false);
                setTimeout(() => {
                  setMostrarLoading(true);
                }, 1500);
              }}
              value={busca}
              onChangeText={value => {
                setBusca(value);
                setMostrarbusca(false);
              }}
              placeholder={`O que voce procura em ${pesquisa}?`}
              placeholderTextColor={'#8E8E8E'}
              style={estilos.input}></TextInput>
          </View>
          <TouchableOpacity
            onPress={() => {
              buscar();
              input.current.blur();
              if (busca) setMostrarx(true);
              setMostrarLoading(false);
              setTimeout(() => {
                setMostrarLoading(true);
              }, 1500);
            }}
            style={{
              position: 'absolute',
              alignSelf: 'center',
              right: 50,
              padding: 10,
            }}>
            <Image
              style={estilos.imgLupa}
              source={require('../../images/buscar.png')}
            />
          </TouchableOpacity>
          {mostrarx && (
            <TouchableOpacity
              onPress={() => {
                setMostrarbusca(false);
                limpaBusca();
                setBusca('');
                input.current.blur();
                setMostrarx(false);
              }}
              style={{
                position: 'absolute',
                alignSelf: 'center',
                left: 40,
                padding: 10,
              }}>
              <Image
                style={estilos.img2}
                source={require('../../images/close.png')}
              />
            </TouchableOpacity>
          )}
        </View>
        <View
          style={{
            flexDirection: 'row',
            marginTop: 10,
            paddingTop: 10,
            justifyContent: 'space-around',
          }}>
          <TouchableOpacity
            style={estilos.containerIcon}
            onPress={() => {
              btnfiltro('preco');
              scrollRef.current.scrollToOffset({
                offset: 0,
                animated: true,
              });
            }}>
            <Image style={estilos.img} source={iconpreco} />
            <Text style={estilos.txt}>Preço</Text>
          </TouchableOpacity>
          <TouchableOpacity
            style={estilos.containerIcon}
            onPress={() => {
              btnfiltro('avaliacao');
              scrollRef.current.scrollToOffset({
                offset: 0,
                animated: true,
              });
            }}>
            <Image style={estilos.img} source={iconestrelas} />
            <Text style={estilos.txt}>Avaliação</Text>
          </TouchableOpacity>
          <TouchableOpacity
            style={estilos.containerIcon}
            onPress={() => {
              btnfiltro('distancia');
              scrollRef.current.scrollToOffset({
                offset: 0,
                animated: true,
              });
            }}>
            <Image style={estilos.img} source={icondistancia} />
            <Text style={estilos.txt}>Distância</Text>
          </TouchableOpacity>
          <TouchableOpacity
            style={estilos.containerIcon}
            onPress={() => {
              btnfiltro('maisprocurados');
              scrollRef.current.scrollToOffset({
                offset: 0,
                animated: true,
              });
            }}>
            <Image style={estilos.img} source={iconmaisprocurados} />
            <Text style={estilos.txt}>{'Mais\nProcurados'}</Text>
          </TouchableOpacity>
          <TouchableOpacity
            style={estilos.containerIcon}
            onPress={() => {
              btnfiltro('filtro');
              scrollRef.current.scrollToOffset({
                offset: 0,
                animated: true,
              });
            }}>
            <Image style={estilos.img} source={iconfiltro} />
            <Text style={estilos.txt}>Filtro</Text>
          </TouchableOpacity>
        </View>
        <Image
          source={require('../../images/line.png')}
          style={{
            alignSelf: 'center',
            resizeMode: 'contain',
            marginTop: 10,
          }}
        />
      </Animated.View>
      <View
        style={{
          flex: 1,
        }}>
        <FlatList
          scrollEventThrottle={16}
          onScroll={Animated.event(
            [
              {
                nativeEvent: {
                  contentOffset: {y: scrollY},
                },
              },
            ],
            {useNativeDriver: false},
          )}
          ref={scrollRef}
          data={filtro3}
          keyExtractor={item => String(item.idApp)}
          renderItem={({item}) => <CardDetalhes data={item} />}
          showsVerticalScrollIndicator={false}
          ListHeaderComponent={
            <>
              <View style={{height: 230}}></View>
              <View
                style={{
                  paddingHorizontal: 35,
                  paddingTop: 10,
                }}>
                {
                  ordenado && (
                    <View style={{flexDirection: 'row', height: 25}}>
                      <Text
                        style={[
                          estilos.txt,
                          {textAlign: 'left', fontSize: 15},
                        ]}>
                        Ordenado por{' '}
                      </Text>
                      <Text
                        style={[
                          estilos.txt,
                          {textAlign: 'left', fontSize: 16, fontWeight: 'bold'},
                        ]}>
                        {ordenado}
                      </Text>
                    </View>
                  )
                  // : (
                  //   <View style={{height: 25}}></View>
                  // )
                }
                {mostrarbusca && (
                  <View style={{marginBottom: -15}}>
                    <Text style={estilos.h1}>Busca</Text>
                    <View style={{flexDirection: 'row'}}>
                      <Text style={estilos.txt2}>Resultado de busca para </Text>
                      <Text
                        style={[
                          estilos.txt2,
                          {fontFamily: 'Poppins-Bold', color: '#000'},
                        ]}>
                        {busca?.toUpperCase()}:
                      </Text>
                    </View>
                  </View>
                )}
                {filtroLigado && (
                  <View style={{marginBottom: -10}}>
                    <Text style={estilos.h1}>Filtro</Text>
                    <View>
                      <Text style={[estilos.txt2, {fontSize: 13}]}>
                        Resultados encontrados para o filtro selecionado
                      </Text>
                    </View>
                  </View>
                )}
              </View>
            </>
          }
          ListEmptyComponent={
            <>
              {!mostrarLoading ? (
                <View
                  style={{
                    marginTop: 150,
                    alignItems: 'center',
                    justifyContent: 'center',
                  }}>
                  <ActivityIndicator size={50} color="#910046" />
                </View>
              ) : filtroLigado ? (
                <View>
                  <View style={{marginHorizontal: 30, marginVertical: 50}}>
                    <View style={{alignItems: 'center'}}>
                      <Image
                        style={{width: 40, height: 40}}
                        source={require('../../images/paginadetalhes/warning-purple.png')}
                      />
                      <Text
                        style={{
                          fontFamily: 'Poppins-Regular',
                          fontSize: 16,
                          color: '#000',
                          textAlign: 'center',
                          marginTop: 5,
                        }}>
                        Não foi encontrado resultados para o filtro selecionado.
                      </Text>
                      <TouchableOpacity
                        style={[estilos.btn, {width: '50%'}]}
                        onPress={() => {
                          limpaBusca();
                          setIconfiltro(
                            require('../../images/menupages/filtro.png'),
                          );
                          setSelectAcademia(false);
                          setSelectEstacionamento(false);
                          setSelectAcessibilidade(false);
                          setSelectArcondicionado(false);
                          setSelectAnimais(false);
                          setSelectBar(false);
                          setSelectPiscina(false);
                          setSelectRefeicao(false);
                          setSelectWifi(false);
                          setSelectTrilhas(false);
                        }}>
                        <Text
                          style={{
                            fontSize: 24,
                            fontFamily: 'Poppins-Regular',
                            color: '#fff',
                            paddingTop: 5,
                          }}>
                          ok
                        </Text>
                      </TouchableOpacity>
                    </View>
                  </View>
                </View>
              ) : (
                <View>
                  <View style={{marginHorizontal: 30, marginVertical: 50}}>
                    <View style={{alignItems: 'center'}}>
                      <Image
                        style={{width: 40, height: 40}}
                        source={require('../../images/paginadetalhes/warning-purple.png')}
                      />
                      <Text
                        style={{
                          fontFamily: 'Poppins-Regular',
                          fontSize: 16,
                          color: '#000',
                          textAlign: 'center',
                          marginTop: 5,
                        }}>
                        Não foi encontrado resultados para:
                      </Text>
                      <Text
                        style={{
                          fontFamily: 'Poppins-Bold',
                          fontSize: 16,
                          color: '#000',
                          textAlign: 'center',
                        }}>
                        " {busca} "
                      </Text>
                    </View>
                  </View>
                </View>
              )}
            </>
          }
          onEndReached={() => {
            setAdditem(additem + 1);
          }}
          onEndReachedThreshold={0.15}
          ListFooterComponent={
            <>
              {loading && additem > 3 ? (
                <View
                  style={{
                    marginBottom: 10,
                    alignItems: 'center',
                    justifyContent: 'center',
                  }}>
                  <ActivityIndicator size={35} color="#910046" />
                </View>
              ) : (
                <View style={{marginBottom: 45}}></View>
              )}
            </>
          }
        />
      </View>
      <View>
        <Modal
          visible={mostrarfiltro}
          transparent={true}
          animationType={'fade'}>
          <View style={estilos.containerModal}>
            <View
              style={{
                flexDirection: 'row',
                justifyContent: 'space-between',
                alignItems: 'center',
              }}>
              <Text style={estilos.txtFiltro}>
                Selecione as opções abaixo para filtrar.
              </Text>
              <TouchableOpacity
                onPress={() => {
                  setMostrarfiltro(false);
                }}>
                <Image
                  style={{height: 25, width: 25}}
                  source={require('../../images/configuracao/close.png')}
                />
              </TouchableOpacity>
            </View>
            <View
              style={{
                flex: 1,
                padding: 10,
                paddingBottom: 0,
              }}>
              <ScrollView>
                <View
                  style={{
                    flexDirection: 'row',
                    alignItems: 'center',
                    marginBottom: 15,
                  }}>
                  <CheckBox
                    value={selectEstacionamento}
                    onValueChange={selectionEstacionamento}
                    style={{transform: [{scaleX: 1.2}, {scaleY: 1.2}]}}
                    tintColors={{true: '#910046', false: '#910046'}}
                  />
                  <Image
                    style={estilos.imgFiltro}
                    source={require('../../images/paginadetalhes/estacionamento.png')}
                  />
                  <Text style={[estilos.txtFiltro, {top: 4}]}>
                    Estacionamento
                  </Text>
                </View>

                <View
                  style={{
                    flexDirection: 'row',
                    alignItems: 'center',
                    marginBottom: 15,
                  }}>
                  <CheckBox
                    value={selectPiscina}
                    onValueChange={selectionPiscina}
                    style={{transform: [{scaleX: 1.2}, {scaleY: 1.2}]}}
                    tintColors={{true: '#910046', false: '#910046'}}
                  />
                  <Image
                    style={estilos.imgFiltro}
                    source={require('../../images/paginadetalhes/piscina.png')}
                  />
                  <Text style={[estilos.txtFiltro, {top: 4}]}>Piscina</Text>
                </View>

                <View
                  style={{
                    flexDirection: 'row',
                    alignItems: 'center',
                    marginBottom: 15,
                  }}>
                  <CheckBox
                    value={selectArcondicionado}
                    onValueChange={selectionArcondicionado}
                    style={{transform: [{scaleX: 1.2}, {scaleY: 1.2}]}}
                    tintColors={{true: '#910046', false: '#910046'}}
                  />
                  <Image
                    style={estilos.imgFiltro}
                    source={require('../../images/paginadetalhes/arcondicionado.png')}
                  />
                  <Text style={[estilos.txtFiltro, {top: 4}]}>
                    Ar-condicionado
                  </Text>
                </View>

                <View
                  style={{
                    flexDirection: 'row',
                    alignItems: 'center',
                    marginBottom: 15,
                  }}>
                  <CheckBox
                    value={selectRefeicao}
                    onValueChange={selectionRefeicao}
                    style={{transform: [{scaleX: 1.2}, {scaleY: 1.2}]}}
                    tintColors={{true: '#910046', false: '#910046'}}
                  />
                  <Image
                    style={estilos.imgFiltro}
                    source={require('../../images/paginadetalhes/refeicao.png')}
                  />
                  <Text style={[estilos.txtFiltro, {top: 4}]}>Refeicao</Text>
                </View>

                <View
                  style={{
                    flexDirection: 'row',
                    alignItems: 'center',
                    marginBottom: 15,
                  }}>
                  <CheckBox
                    value={selectAcademia}
                    onValueChange={selectionAcademia}
                    style={{transform: [{scaleX: 1.2}, {scaleY: 1.2}]}}
                    tintColors={{true: '#910046', false: '#910046'}}
                  />
                  <Image
                    style={estilos.imgFiltro}
                    source={require('../../images/paginadetalhes/academia.png')}
                  />
                  <Text style={[estilos.txtFiltro, {top: 4}]}>Academia</Text>
                </View>

                <View
                  style={{
                    flexDirection: 'row',
                    alignItems: 'center',
                    marginBottom: 15,
                  }}>
                  <CheckBox
                    value={selectWifi}
                    onValueChange={selectionWifi}
                    style={{transform: [{scaleX: 1.2}, {scaleY: 1.2}]}}
                    tintColors={{true: '#910046', false: '#910046'}}
                  />
                  <Image
                    style={estilos.imgFiltro}
                    source={require('../../images/paginadetalhes/wifi.png')}
                  />
                  <Text style={[estilos.txtFiltro, {top: 4}]}>Wi-fi</Text>
                </View>

                <View
                  style={{
                    flexDirection: 'row',
                    alignItems: 'center',
                    marginBottom: 15,
                  }}>
                  <CheckBox
                    value={selectAcessibilidade}
                    onValueChange={selectionAcessibilidade}
                    style={{transform: [{scaleX: 1.2}, {scaleY: 1.2}]}}
                    tintColors={{true: '#910046', false: '#910046'}}
                  />
                  <Image
                    style={estilos.imgFiltro}
                    source={require('../../images/paginadetalhes/acessibilidade.png')}
                  />
                  <Text style={[estilos.txtFiltro, {top: 4}]}>
                    Acessibilidade
                  </Text>
                </View>

                <View
                  style={{
                    flexDirection: 'row',
                    alignItems: 'center',
                    marginBottom: 15,
                  }}>
                  <CheckBox
                    value={selectTrilhas}
                    onValueChange={selectionTrilhas}
                    style={{transform: [{scaleX: 1.2}, {scaleY: 1.2}]}}
                    tintColors={{true: '#910046', false: '#910046'}}
                  />
                  <Image
                    style={estilos.imgFiltro}
                    source={require('../../images/paginadetalhes/trilhas.png')}
                  />
                  <Text style={[estilos.txtFiltro, {top: 4}]}>Trilhas</Text>
                </View>

                <View
                  style={{
                    flexDirection: 'row',
                    alignItems: 'center',
                    marginBottom: 15,
                  }}>
                  <CheckBox
                    value={selectBar}
                    onValueChange={selectionBar}
                    style={{transform: [{scaleX: 1.2}, {scaleY: 1.2}]}}
                    tintColors={{true: '#910046', false: '#910046'}}
                  />
                  <Image
                    style={estilos.imgFiltro}
                    source={require('../../images/paginadetalhes/bar.png')}
                  />
                  <Text style={[estilos.txtFiltro, {top: 4}]}>Bar</Text>
                </View>

                <View
                  style={{
                    flexDirection: 'row',
                    alignItems: 'center',
                    marginBottom: 15,
                  }}>
                  <CheckBox
                    value={selectAnimais}
                    onValueChange={selectionAnimais}
                    style={{transform: [{scaleX: 1.2}, {scaleY: 1.2}]}}
                    tintColors={{true: '#910046', false: '#910046'}}
                  />
                  <Image
                    style={estilos.imgFiltro}
                    source={require('../../images/paginadetalhes/animais.png')}
                  />
                  <Text style={[estilos.txtFiltro, {top: 4}]}>
                    Aceita animais de estimação
                  </Text>
                </View>

                <View
                  style={{
                    flex: 1,
                    alignItems: 'center',
                    justifyContent: 'center',
                    marginBottom: 40,
                  }}>
                  <TouchableOpacity
                    style={estilos.btn}
                    onPress={FiltrarDetalhes}>
                    <Text
                      style={{
                        fontSize: 24,
                        fontFamily: 'Poppins-Regular',
                        color: '#fff',
                        paddingTop: 5,
                      }}>
                      Filtrar
                    </Text>
                  </TouchableOpacity>
                </View>
              </ScrollView>
            </View>
          </View>
        </Modal>
      </View>
    </View>
  );
}

const estilos = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
  },

  menuBar: {
    Flex: 1,
    marginTop: 18,
  },

  h1: {
    marginTop: 5,
    fontSize: 20,
    fontFamily: 'Poppins-SemiBold',
    color: '#910046',
  },
  txt: {
    fontSize: 15,
    fontFamily: 'Poppins-Regular',
    color: '#414141',
  },
  containerIcon: {
    height: 70,
    alignItems: 'center',
  },
  txt: {
    paddingTop: 6,
    fontFamily: 'Roboto-Regular',
    textAlign: 'center',
    fontSize: 12,
    color: '#111',
  },
  txt2: {
    top: -10,
    fontFamily: 'Poppins-Regular',
    fontSize: 14,
    color: '#111',
  },
  img: {
    height: 40,
    width: 40,
    resizeMode: 'contain',
  },
  input: {
    width: '85%',
    height: 48,
    fontSize: 12,
    top: 2,
    paddingLeft: 30,
    borderColor: '#E7E7E7',
    backgroundColor: '#E7E7E7',
    fontFamily: 'Poppins-Regular',
    borderRadius: 8,
    color: '#333',
  },
  containerBusca: {
    width: '100%',
    height: 50,
    borderColor: '#E7E7E7',
    backgroundColor: '#E7E7E7',
    fontFamily: 'Poppins-Regular',
    borderRadius: 8,
  },
  imgLupa: {
    height: 25,
    width: 25,
    resizeMode: 'contain',
  },
  img2: {
    height: 15,
    width: 15,
    resizeMode: 'contain',
  },
  containerModal: {
    alignSelf: 'center',
    width:
      Dimensions.get('window').width - Dimensions.get('window').width * 0.02,
    height: Dimensions.get('window').height - 220,
    padding: 15,
    paddingBottom: 0,
    backgroundColor: '#fff',
    elevation: 5,
    borderTopLeftRadius: 15,
    borderTopRightRadius: 15,
    top: 220,
  },
  btnBg: {
    width: 100,
    height: 45,
    backgroundColor: '#CCC',
    borderRadius: 34,
    alignItems: 'center',
    justifyContent: 'center',
    marginHorizontal: 20,
  },
  txtModal: {
    textAlign: 'center',
    fontSize: 16,
    fontFamily: 'Poppins-Regular',
    marginTop: 10,
    color: '#000',
  },
  txtFiltro: {
    fontFamily: 'Poppins-Regular',
    fontSize: 14,
    color: '#111',
  },
  imgFiltro: {
    height: 25,
    width: 25,
    marginRight: 14,
    marginLeft: 7,
    resizeMode: 'contain',
  },
  btn: {
    marginTop: 20,
    width: '90%',
    height: 45,
    borderRadius: 33,
    backgroundColor: '#910046',
    alignItems: 'center',
    justifyContent: 'center',
  },
});
