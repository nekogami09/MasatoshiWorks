//
//  hardMazeViewController.h
//  maze_practice
//
//  Created by g-2015 on 2013/08/21.
//  Copyright (c) 2013年 g-2015. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface hardMazeViewController : UIViewController{
    //NSMutableArray *maze;
    int maze_H[21][21]; //迷路の
    UIImageView *mazeImage_H[21][21];   //迷路の画像
    UIImageView *charaImage_H;    //プレイヤーキャラ画像
    UIImage *charaGraph_H[4][2];
    unsigned int charaGraphCount_H;
    int charaPos_H[2];    //キャラの座標x、y
    UIImageView *goalImage_H; //ゴール画像
    int remainingTime_H;      //残り時間
    NSTimer *customtimer_H;   //タイマー
    NSTimer *btnTimer_H[4]; //ボタンを押したら動くタイマー
}
@property (weak, nonatomic) IBOutlet UILabel *timeLabel_H;

- (void)mezeDisplay_H;
- (void)timeAction_H:(id)sender;
- (void)cahraMoveLeft_H;
- (IBAction)leftBtnDown_H:(id)sender;
- (IBAction)leftBtn_H:(id)sender;
- (void)cahraMoveUp_H;
- (IBAction)upBtnDown_H:(id)sender;
- (IBAction)upBtn_H:(id)sender;
- (void)cahraMoveDown_H;
- (IBAction)downBtnDown_H:(id)sender;
- (IBAction)dwonBtn_H:(id)sender;
- (void)cahraMoveRight_H;
- (IBAction)rightBtnDown_H:(id)sender;
- (IBAction)rightBtn_H:(id)sender;
- (IBAction)titleBtn_H:(id)sender;


@end
